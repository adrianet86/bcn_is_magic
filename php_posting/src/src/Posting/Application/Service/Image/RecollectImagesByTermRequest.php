<?php


namespace App\Posting\Application\Service\Image;


class RecollectImagesByTermRequest
{
    private string $term;
    private string $provider;

    public function __construct(string $term, string $provider)
    {
        $this->term = $term;
        $this->provider = $provider;
    }

    public function term(): string
    {
        return $this->term;
    }

    public function provider(): string
    {
        return $this->provider;
    }
}