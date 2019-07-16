<?php


namespace App\Posting\Infrastructure\Api\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageStorage;
use Aws\S3\S3Client;

class AwsImageStorage implements ImageStorage
{
    /** @var S3Client */
    private S3Client $s3;
    private string $bucket;
    private string $key;
    private string $secret;
    private string $region;
    private string $tmpPath;
    private bool $removeImages;

    public function __construct(
        string $key,
        string $secret,
        string $bucket,
        string $region,
        string $tmpPath,
        bool $removeImages
    )
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->bucket = $bucket;
        $this->region = $region;
        $this->tmpPath = $tmpPath;
        $this->removeImages = $removeImages;

        // Instantiate an Amazon S3 client.
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret
            ]
        ]);
    }

    /**
     * @param Image $image
     */
    public function store(Image $image): void
    {
        $tmpPath = $this->tmpPath . time();
        try {
            $imageTemp = file_get_contents($image->providerUrl());
            file_put_contents($tmpPath, $imageTemp);

            $mime = mime_content_type($tmpPath);
            $extension = str_replace('image/', '', $mime);
            $imageName = $image->provider() . '_' . $image->providerId() . '.' . $extension;

            $response = $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $imageName,
                'SourceFile' => $tmpPath
            ]);

            $image->setPath($response->get('ObjectURL'));

            unlink($tmpPath);

        } catch (\Exception $exception) {
            unlink($tmpPath);
        }

    }

    /**
     * @param Image $image
     */
    public function remove(Image $image): void
    {
        if ($this->removeImages && !is_null($image->path())) {
            $this->s3->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $image->path()
            ]);
            $image->removePath();
        }
    }
}