<?php


namespace App\Posting\Domain\Model\Image;


interface ImageRepository
{
    /**
     * @param Image $image
     */
    public function save(Image $image): void;

    /**
     * @param string $provider
     * @param string $providerId
     * @return Image
     * @throws ImageNotFoundException
     */
    public function byProvider(string $provider, string $providerId): Image;
}