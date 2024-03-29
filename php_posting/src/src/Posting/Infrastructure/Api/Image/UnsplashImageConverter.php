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
    const NAME = 'name';
    const VIEWS = 'views';
    const DOWNLOADS = 'downloads';
    const LOCATION = 'location';

    public static function convert($imageSource): Image
    {
        if (is_string($imageSource)) {
            $imageSource = json_decode($imageSource, true);
        }

        $providerUrl = $imageSource[self::PROVIDER_URL][self::IMAGE_SIZE];
        $author = $imageSource[self::AUTHOR][self::NAME];

        $location = null;
        if (isset($imageSource[self::LOCATION])) {
            $location = $imageSource[self::LOCATION][self::NAME];
        }
        $views = 0;
        if (isset($imageSource[self::VIEWS])) {
            $views = $imageSource[self::VIEWS];
        }
        $downloads = 0;
        if (isset($imageSource[self::DOWNLOADS])) {
            $downloads = $imageSource[self::DOWNLOADS];
        }

        $image = Image::create(
            $imageSource[self::PROVIDER_ID],
            self::PROVIDER,
            $providerUrl,
            self::getDescription($imageSource),
            $location,
            $imageSource[self::LIKES],
            0,
            $views,
            $downloads,
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
                $tags[] = trim(strtolower($tag[self::TAG_TITLE]));
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

    private static function getDescription(array $imageSource): ?string
    {
        if (isset($imageSource[self::DESCRIPTION]) && !empty($imageSource[self::DESCRIPTION])) {
            $description = $imageSource[self::DESCRIPTION];
            if (strlen($description) > 255) {
                $description = substr($description, 0, 254) . PHP_EOL;
            }

            return $description;
        }
        return null;
    }
}