<?php


namespace Unit\Posting\Infrastructure\Api\Image;


use PHPUnit\Framework\TestCase;
use App\Posting\Infrastructure\Api\Image\UnsplashImageProvider;

class UnsplashImageProviderTest extends TestCase
{
    public function testApi()
    {
        $appName = 'ig_posting';
        $secret = '325490bf8198503e83468dacc5b72788c86aed192508497a2d0aa0f511f42f71';
        $key = '33d2c3d0503fc943f885f39081154db1f33092af6597389aa99e4f1b3941cf68';
        $imageProvider = new UnsplashImageProvider(
            $key,
            $secret,
            $appName
        );

        $images = $imageProvider->byTerm('barcelona');

        $this->assertNotEmpty($images);
        $firstImage = $images[0];
        $json = json_encode($firstImage);
        echo $json;
    }
}