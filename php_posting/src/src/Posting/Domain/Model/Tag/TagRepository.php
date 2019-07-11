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

    /**
     * @param int $limit
     * @return array Tag
     */
    public function hashTags(int $limit = 30): array;
}