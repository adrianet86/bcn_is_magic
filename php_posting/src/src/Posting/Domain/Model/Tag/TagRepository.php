<?php


namespace App\Posting\Domain\Model\Tag;


interface TagRepository
{
    /**
     * @return array Tag
     */
    public function allNonExcluding(): array;

    /**
     * @return array Tag
     */
    public function allExcluding(): array;
}