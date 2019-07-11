<?php


namespace App\Posting\Application\Service\Image;


class PostImageRequest
{
    private string $imageId;

    public function __construct(string $imageId)
    {
        $this->imageId = $imageId;
    }

    public function imageId(): string
    {
        return $this->imageId;
    }
}