<?php


namespace App\Posting\Domain\Model\Image;


interface PostImage
{
    /**
     * @param Image $image
     * @param string|null $imagePath
     * @throws UnableToPostImageException
     */
    public function postImage(Image $image, ?string $imagePath): void;
}