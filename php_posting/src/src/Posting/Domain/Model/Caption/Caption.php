<?php


namespace App\Posting\Domain\Model\Caption;


class Caption
{
    private string $text;
    private string $locale;

    public function __construct(string $text, string $locale)
    {
        $this->text = $text;
        $this->locale = $locale;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function locale(): string
    {
        return $this->locale;
    }
}