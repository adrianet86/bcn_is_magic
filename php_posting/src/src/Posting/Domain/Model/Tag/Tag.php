<?php


namespace App\Posting\Domain\Model\Tag;


class Tag
{
    private string $tag;
    private bool $isExcluding;
    private bool $isHashTag;

    public function __construct(string $tag, bool $isExcluding, bool $isHashTag)
    {
        $this->tag = trim(strtolower($tag));
        $this->isExcluding = $isExcluding;
        $this->isHashTag = $isHashTag;
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