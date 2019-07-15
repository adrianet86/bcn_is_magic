<?php


namespace App\Posting\Infrastructure\Api\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\PostImage;
use App\Posting\Domain\Model\Image\UnableToPostImageException;
use InstagramAPI\Instagram;

class IgPostImageAdapter implements PostImage
{
    private Instagram $ig;
    private string $username;
    private string $password;
    private string $path;

    public function __construct(
        array $config,
        bool $debug,
        bool $truncatedDebug,
        string $username,
        string $password,
        string $path
    )
    {
        $this->ig = new Instagram(
            $debug,
            $truncatedDebug,
            $config
        );
        $this->username = $username;
        $this->password = $password;
        $this->path = $path;
    }

    public function postImage(Image $image): void
    {
        try {
            $imagePath = $image->path();
            if ($this->imageIsInCloud($image)) {
                $tmpPath = $this->path . time();
                $imageTemp = file_get_contents($image->providerUrl());
                file_put_contents($tmpPath, $imageTemp);
                $mime = mime_content_type($tmpPath);
                $extension = str_replace('image/', '', $mime);
                unlink($tmpPath);

                $imagePath = $this->path . time() . '.' . $extension;
                file_put_contents($imagePath, $imageTemp);
                chmod($imagePath, 777);
            }
            $this->ig->login($this->username, $this->password);

            $this->ig->timeline->uploadPhoto($imagePath, ['caption' => $image->caption()]);
            $image->posted();

            // Delete temporal file
            if ($this->imageIsInCloud($image)) {
                unlink($imagePath);
            }

        } catch (\Exception $exception) {
            throw new UnableToPostImageException('UNABLE TO POST IMAGE: ' . $exception->getMessage());
        }
    }

    private function imageIsInCloud(Image $image): bool
    {
        return strpos($image->path(), 'https://') !== false;
    }
}