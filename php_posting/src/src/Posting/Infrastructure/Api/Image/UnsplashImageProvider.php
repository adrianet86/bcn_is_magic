<?php


namespace App\Posting\Infrastructure\Api\Image;


use Crew\Unsplash\HttpClient;
use Crew\Unsplash\Search;
use App\Posting\Domain\Model\Image\ImageProvider;

class UnsplashImageProvider implements ImageProvider
{
    const LIMIT = 50;

    public function __construct(string $appId, string $secretKey, string $appName)
    {
        HttpClient::init([
            'applicationId' => $appId,
            'secret' => $secretKey,
//            'callbackUrl'	=> 'https://your-application.com/oauth/callback',
            'callbackUrl' => 'urn:ietf:wg:oauth:2.0:oob',
            'utmSource' => $appName
        ]);
    }

    public function byTerm(string $term): array
    {
//        $pageResult = Search::photos($term, 1, self::LIMIT);
        $pageResult = Search::photos($term,);

        $totalImages = $pageResult->getTotal();

        $images = [];
        if ($pageResult->getTotal() > 0) {
            foreach ($pageResult->getResults() as $imageSource) {
                $images[] = UnsplashImageConverter::convert($imageSource);
            }
        }

        return $images;
    }
}