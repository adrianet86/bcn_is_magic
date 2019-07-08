<?php


namespace App\Posting\Domain\Model\Image;


interface ImageProvider
{
    public function byTerm(string $term, int $page, int $limit): array;

    public function totalByTerm(string $term): int;
}