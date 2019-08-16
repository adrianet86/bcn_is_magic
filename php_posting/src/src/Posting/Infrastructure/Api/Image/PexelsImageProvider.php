<?php


namespace App\Posting\Infrastructure\Api\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageProvider;
use GuzzleHttp\Client;

class PexelsImageProvider implements ImageProvider
{
    const TIMEOUT = 20;
    const WAIT = 2;
    const PROVIDER = 'pexels';

    private string $secretKey;
    /** @var Client */
    private Client $client;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
        $this->client = new Client([
            'base_uri' => 'https://api.pexels.com/',
            'http_errors' => true,
            'Authorization' => $this->secretKey,
            'connect_timeout' => self::TIMEOUT,
            'timeout' => self::TIMEOUT
        ]);
    }

    public function byTerm(string $term, int $page, int $limit): array
    {
        $uri = "/v1/search?query=" . $term . '&per_page=' . $limit . '&page=' . $page;
        $response = $this->client->get($uri, [
            'headers' => [
                'Authorization' => $this->secretKey
            ]
        ]);

        $content = json_decode($response->getBody()->getContents(), true);
        $images = [];

        foreach ($content['photos'] as $photo) {
            $images[] = Image::create(
                $photo['id'],
                self::PROVIDER,
                $photo['src']['large2x'],
                null,
                null,
                0,
                0,
                0,
                0,
                $photo['photographer'],
                []
            );
        }

        return $images;
    }

    public function totalByTerm(string $term): int
    {
        $uri = "/v1/search?query=" . $term;
        $response = $this->client->get($uri, [
            'headers' => [
                'Authorization' => $this->secretKey
            ]
        ]);

        $content = json_decode($response->getBody()->getContents(), true);

        return $content['total_results'];
    }

    private function getImage($id)
    {
        $client = new Client([
            'base_uri' => 'https://api.pexels.com/v1',
            'timeout' => 2.0,
            'http_errors' => true,
            ''
        ]);
        $uri = "/photos/" . $id;
        $response = $client->get($uri, [
            'headers' => [
                'connect_timeout' => self::TIMEOUT,
                'timeout' => self::TIMEOUT,
                'Authorization' => $this->secretKey
            ]
        ]);

        return $response->getBody()->getContents();
    }
}