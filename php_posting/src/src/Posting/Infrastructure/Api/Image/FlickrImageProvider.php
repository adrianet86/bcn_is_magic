<?php

namespace App\Posting\Infrastructure\Api\Image;

use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageProvider;
use GuzzleHttp\Client;

class FlickrImageProvider implements ImageProvider
{
    private const URL = 'https://api.flickr.com/services/rest/?';
    const TIMEOUT = 20;
    const WAIT = 2;
    const PROVIDER = 'flickr';

    private Client $client;
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.flickr.com/services/rest',
            'timeout' => 2.0,
            'http_errors' => true
        ]);
    }

    private function byTermRequest(string $term, int $page, int $limit)
    {
        $uri = "?method=flickr.photos.search" .
            "&api_key=" . $this->apiKey .
            "&text=" . $term .
            "&page=" . $page .
            "&per_page=" . $limit .
            "&format=json&nojsoncallback=1&sort=interestingness-desc&privacy_filter=1&accuracy=11&content_type=1";

        $response = $this->client->get($uri, [
            'headers' => [
                'connect_timeout' => self::TIMEOUT,
                'timeout' => self::TIMEOUT
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function byTerm(string $term, int $page, int $limit): array
    {
        $content = $this->byTermRequest($term, $page, $limit);
        $images = [];

        foreach ($content['photos']['photo'] as $photo) {
            $images[] = $this->getImage($photo);
            sleep(self::WAIT);
        }
        return $images;
    }

    public function totalByTerm(string $term): int
    {
        $content = $this->byTermRequest($term, 1, 10);
        return (int)$content['photos']['total'];
    }

    private function getImage(array $photo): Image
    {
        $uri = "?method=flickr.photos.getInfo" .
            "&api_key=" . $this->apiKey .
            "&photo_id=" . $photo['id'] .
            "&format=json&nojsoncallback=1";

        $response = $this->client->get($uri, [
            'headers' => [
                'connect_timeout' => self::TIMEOUT,
                'timeout' => self::TIMEOUT
            ]
        ]);

        $photoInfo = json_decode($response->getBody()->getContents(), true);
        $photoInfo = $photoInfo['photo'];

        $imageUrl = $this->getImageUrl($photo['id']);
        $tags = $this->getTags($photoInfo);
        $title = $photo['title'];
        $numberOfComments = (int)($photoInfo['comments']['_content'] ?: 0);
        $views = (int)$photoInfo['views'] ?: null;
        $author = $photoInfo['owner']['realname'];

        return Image::create(
            $photo['id'],
            self::PROVIDER,
            $imageUrl,
            $title,
            null,
            0,
            $numberOfComments,
            $views,
            0,
            $author,
            $tags
        );
    }

    private function getImageUrl($id): ?string
    {
        $uri = "?method=flickr.photos.getSizes" .
            "&api_key=" . $this->apiKey .
            "&photo_id=" . $id .
            "&format=json&nojsoncallback=1";

        $response = $this->client->get($uri, [
            'headers' => [
                'connect_timeout' => self::TIMEOUT,
                'timeout' => self::TIMEOUT
            ]
        ]);

        $photoInfo = json_decode($response->getBody()->getContents(), true);
        $sizes = $photoInfo['sizes']['size'];

        $url = null;
        foreach ($sizes as $size) {
            if ($size['label'] == 'Medium') {
                $url = $size['source'];
            }
            if ($size['label'] == 'Large') {
                return $size['source'];
            }
        }
        return $url;
    }

    private function getTags($photoInfo): array
    {
        $tags = [];
        if (!empty($photoInfo['tags']['tag'])) {
            foreach ($photoInfo['tags']['tag'] as $tag) {
                $tags[] = $tag['_content'];
            }
        }
        return $tags;
    }
}