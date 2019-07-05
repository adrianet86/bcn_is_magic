<?php


namespace App\Posting\Domain\Model\Image;


interface ImageRepository
{
    public function save(Image $image);
}