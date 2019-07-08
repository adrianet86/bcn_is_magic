<?php


namespace App\Posting\Infrastructure\File\Tag;


use App\Posting\Domain\Model\Tag\Tag;
use App\Posting\Domain\Model\Tag\TagRepository;

class FileTagRepository implements TagRepository
{
    private $excludingTags = [
        'portrait',
        'human',
        'person',
        'male',
        'female',
        'animal',
        'wallpapers',
        'shadow',
        'silhouette',
        'word',
        'words',
        'food',
        'plant',
    ];

    private $nonExcludingTags = [
        'beach',
        'sea',
        'architecture',
        'style',
        'history',
        'la pedrera',
        'tibidabo',
        'camp nou',
        'guell',
        'aerial view',
        'building',
        'gaudi',
        'sagrada familia',
    ];

    /**
     * @return array Tag
     */
    public function allNonExcluding(): array
    {
        $tags = [];
        foreach ($this->nonExcludingTags as $nonExcludingTag) {
            $tags[] = new Tag($nonExcludingTag, false);
        }

        return $tags;
    }

    /**
     * @return array Tag
     */
    public function allExcluding(): array
    {
        $tags = [];
        foreach ($this->excludingTags as $excludingTag) {
            $tags[] = new Tag($excludingTag, true);
        }

        return $tags;
    }
}