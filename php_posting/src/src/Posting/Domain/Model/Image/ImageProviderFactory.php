<?php


namespace App\Posting\Domain\Model\Image;


use App\Posting\Infrastructure\Api\Image\PexelsImageProvider;
use App\Posting\Infrastructure\Api\Image\UnsplashImageProvider;

class ImageProviderFactory
{
    private $unsplash;
    private $pexels;

    public function __construct(UnsplashImageProvider $unsplash, PexelsImageProvider $pexels)
    {
        $this->unsplash = $unsplash;
        $this->pexels = $pexels;
    }

    public function byName(string $name): ImageProvider
    {
        if ($name == 'unsplash') {
            return $this->unsplash;
        }

        if ($name == 'pexels') {
            return $this->pexels;
        }

        throw new ImageProviderNotFoundException('IMAGE PROVIDER NOT FOUND: ' . $name);
    }
}