<?php


namespace App\Posting\Application\Service\Image;


class RecollectImagesByTermRequest
{
    private string $term;

    public function __construct(string $term)
    {
        $this->term = $term;
    }

    public function term(): string
    {
        return $this->term;
    }
}