<?php


namespace App\Posting\Domain\Model\Image;


interface PostImage
{
    /**
     * @param Image $image
     * @throws UnableToPostImageException
     */
    public function postImage(Image $image): void;
}