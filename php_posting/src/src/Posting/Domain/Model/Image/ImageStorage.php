<?php


namespace App\Posting\Domain\Model\Image;


interface ImageStorage
{
    /**
     * @param Image $image
     */
    public function store(Image $image);
}