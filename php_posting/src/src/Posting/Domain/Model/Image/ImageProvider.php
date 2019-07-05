<?php


namespace App\Posting\Domain\Model\Image;


interface ImageProvider
{
    public function byTerm(string $term): array;
}