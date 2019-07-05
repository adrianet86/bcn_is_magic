<?php


namespace App\Posting\Infrastructure\Api\Image;


use App\Posting\Domain\Model\Image\Image;

class UnsplashImageConverter
{
    const PROVIDER = 'unsplash';
    const PROVIDER_ID = 'id';
    const POSTED_AT = 'created_at';
    const IMAGE_SIZE = 'regular';
    const PROVIDER_URL = 'urls';
    const DESCRIPTION = 'description';
    const LIKES = 'likes';
    const TAGS = 'tags';
    const TAG_TITLE = 'title';
    const AUTHOR = 'user';
    const AUTHOR_NAME = 'name';

    public static function convert($imageSource): Image
    {
        if (is_string($imageSource)) {
            $imageSource = json_decode($imageSource, true);
        }

        $providerUrl = $imageSource[self::PROVIDER_URL][self::IMAGE_SIZE];
        $author = $imageSource[self::AUTHOR][self::AUTHOR_NAME];

        $image = Image::create(
            $imageSource[self::PROVIDER_ID],
            self::PROVIDER,
            $providerUrl,
            (string)$imageSource[self::DESCRIPTION],
            $imageSource[self::LIKES],
            0,
            self::getPostedAt($imageSource),
            $author,
            self::getTags($imageSource)
        );

        return $image;
    }

    public static function getTags(array $imageSource): array
    {
        $providerTags = $imageSource[self::TAGS];
        $tags = [];
        if (!empty($providerTags)) {
            foreach ($providerTags as $tag) {
                $tags[] = $tag[self::TAG_TITLE];
            }
        }

        return $tags;
    }

    /**
     * @param $imageSource
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    public static function getPostedAt($imageSource): \DateTimeImmutable
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp(strtotime($imageSource[self::POSTED_AT]));
        $dateTimeImmutable = \DateTimeImmutable::createFromMutable($dateTime);

        return $dateTimeImmutable;
    }
}