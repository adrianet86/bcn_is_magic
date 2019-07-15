<?php


namespace App\Posting\Infrastructure\Api\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageStorage;
use App\Posting\Infrastructure\File\Image\FileImageStorage;

class AwsImageStorageContext implements ImageStorage
{
    private $prodImageStorage;
    private $devImageStorage;
    private string $environment;

    public function __construct(
        FileImageStorage $devImageStorage,
        AwsImageStorage $prodImageStorage,
        string $environment
    )
    {
        $this->devImageStorage = $devImageStorage;
        $this->prodImageStorage = $prodImageStorage;
        $this->environment = $environment;
    }

    private function imageStorage(): ImageStorage
    {
        if ($this->environment === 'prod') {
            return $this->prodImageStorage;
        }

        return $this->devImageStorage;
    }

    /**
     * @param Image $image
     */
    public function store(Image $image): void
    {
        $this->imageStorage()->store($image);

    }

    /**
     * @param Image $image
     */
    public function remove(Image $image): void
    {
        $this->imageStorage()->remove($image);
    }
}