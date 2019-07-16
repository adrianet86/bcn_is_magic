<?php


namespace App\Posting\Infrastructure\File\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageStorage;

class FileImageStorage implements ImageStorage
{
    private string $path;
    private bool $removeImages;

    public function __construct(string $path, bool $removeImages)
    {
        $this->removeImages = $removeImages;
        $this->path = $path;
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    /**
     * @param Image $image
     */
    public function store(Image $image): void
    {
        $tmpPath = $this->path . time();
        $imageTemp = file_get_contents($image->providerUrl());
        file_put_contents($tmpPath, $imageTemp);

        $mime = mime_content_type($tmpPath);
        $extension = str_replace('image/', '', $mime);
        $imageName = $image->provider() . '_' . $image->providerId() . '.' . $extension;
        $imagePath = $this->path . $imageName;

        if (file_put_contents($imagePath, $imageTemp) !== false) {
            $image->setPath($imagePath);
        }

        unlink($tmpPath);
    }

    /**
     * @param Image $image
     */
    public function remove(Image $image): void
    {
        if ($this->removeImages && !is_null($image->path())) {
            unlink($image->path());
            $image->removePath();
        }

        return;
    }
}