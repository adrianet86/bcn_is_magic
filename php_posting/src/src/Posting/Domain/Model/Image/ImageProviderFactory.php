<?php


namespace App\Posting\Domain\Model\Image;


use App\Posting\Infrastructure\Api\Image\FlickrImageProvider;
use App\Posting\Infrastructure\Api\Image\PexelsImageProvider;
use App\Posting\Infrastructure\Api\Image\UnsplashImageProvider;

class ImageProviderFactory
{
    private $unsplash;
    private $pexels;
    private $flickr;

    public function __construct(
        UnsplashImageProvider $unsplash,
        PexelsImageProvider $pexels,
        FlickrImageProvider $flickr
    ) {
        $this->unsplash = $unsplash;
        $this->pexels = $pexels;
        $this->flickr = $flickr;
    }

    public function byName(string $name): ImageProvider
    {
        if ($name == 'unsplash') {
            return $this->unsplash;
        }

        if ($name == 'pexels') {
            return $this->pexels;
        }

        if ($name == 'flickr') {
            return $this->flickr;
        }

        throw new ImageProviderNotFoundException('IMAGE PROVIDER NOT FOUND: ' . $name);
    }
}