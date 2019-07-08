<?php


namespace App\Posting\Domain\Model\Tag;


class Tag
{
    private string $tag;
    private bool $isExcluding;

    public function __construct(string $tag, bool $isExcluding)
    {
        $this->tag = trim(strtolower($tag));
        $this->isExcluding = $isExcluding;
    }

    public function tag(): string
    {
        return $this->tag;
    }

    public function isExcluding(): bool
    {
        return $this->isExcluding;
    }
}