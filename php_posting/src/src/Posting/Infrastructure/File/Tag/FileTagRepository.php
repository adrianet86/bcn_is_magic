<?php


namespace App\Posting\Infrastructure\File\Tag;


use App\Posting\Domain\Model\Tag\Tag;
use App\Posting\Domain\Model\Tag\TagRepository;

class FileTagRepository implements TagRepository
{
    private $pinnedHashTags = [
        'barcelona',
        'bcn',
        'barcelonacity',
        'barcelona_is_magic',
        'barcelonaismagic',
        'bcnismagic',
        'bcn_is_magic',
        'barcelonagram',
    ];
    private $hashTags = [
        'barcelona_turisme',
        'barcelona_inspira',
        'barcelona_lovers',
        'barcelona_cat',
        'barcelona_world',
        'barcelonabeach',
        'barcelonafood',
        'barcelonafoodies',
        'bcnfoodies',
        'bcnlovers',
        'bcncity',
        'barna',
        'barnart',
        'bcngram',
        'art',
        'photo',
        'photography',
        'architecture',
        'fcb',
        'fcbarcelona',
        'picoftheday',
        'photooftheday',
        'instagood',
        'travelgram',
    ];

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
            $tags[] = new Tag($nonExcludingTag, false, false);
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
            $tags[] = new Tag($excludingTag, true, false);
        }

        return $tags;
    }

    /**
     * @param int $limit
     * @return array Tag
     */
    public function hashTags(int $limit = 30): array
    {
        $totalPinnedHashTags = count($this->pinnedHashTags);
        $total = $limit - $totalPinnedHashTags;

        $randomEntries = array_rand($this->hashTags, $total);
        $tags = [];
        foreach ($this->pinnedHashTags as $pinnedHashTag) {
            $tags[] = new Tag($pinnedHashTag, false, true);
        }
        if (is_array($randomEntries)) {
            foreach ($randomEntries as $randomEntry) {
                $tags[] = new Tag($this->hashTags[$randomEntry], false, true);
            }
        } else {
            $tags[] = new Tag($this->hashTags[$randomEntries], false, true);
        }

        return $tags;
    }
}