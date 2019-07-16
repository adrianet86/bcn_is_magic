<?php


namespace App\Posting\Infrastructure\Api\Image;


use Crew\Unsplash\HttpClient;
use Crew\Unsplash\Search;
use App\Posting\Domain\Model\Image\ImageProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class UnsplashImageProvider implements ImageProvider
{
    const TIMEOUT = 20;
    const WAIT = 1;

    private string $appId;

    public function __construct(string $appId, string $secretKey, string $appName)
    {
        $this->appId = $appId;
        HttpClient::init([
            'applicationId' => $appId,
            'secret' => $secretKey,
            'callbackUrl' => 'urn:ietf:wg:oauth:2.0:oob',
            'utmSource' => $appName
        ]);
    }

    public function byTerm(string $term, int $page, int $limit): array
    {
        $pageResult = Search::photos($term, $page, $limit);
        $images = [];
        $rateLimitExceeded = false;
        if ($pageResult->getTotal() > 0) {
            foreach ($pageResult->getResults() as $imageSource) {
                if ($rateLimitExceeded == false) {
                    try {
                        $image = $this->getImage($imageSource['id']);
                        $images[] = UnsplashImageConverter::convert($image);
                    } catch (ClientException $exception) {
                        $rateLimitExceeded = true;
                        if ($exception->getCode() == 403) {
                            $images[] = UnsplashImageConverter::convert($imageSource);
                        }
                    }
                } else {
                    $images[] = UnsplashImageConverter::convert($imageSource);
                }
            }
        }

        return $images;
    }

    public function totalByTerm(string $term): int
    {
        $pageResult = Search::photos($term);

        return $pageResult->getTotal();
    }

    private function getImage($id)
    {
        $client = new Client([
            'base_uri' => 'https://api.unsplash.com',
            'timeout' => 2.0,
            'http_errors' => true,
            ''
        ]);
        $uri = "/photos/" . $id . '?client_id=' . $this->appId;
        $response = $client->get($uri, [
            'headers' => [
                'connect_timeout' => self::TIMEOUT,
                'timeout' => self::TIMEOUT
            ]
        ]);

        return $response->getBody()->getContents();
    }
}