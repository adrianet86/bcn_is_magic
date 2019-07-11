<?php


namespace App\Unit\Posting\Domain\Model\Image;


use App\Posting\Domain\Model\Caption\Caption;
use App\Posting\Domain\Model\Image\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testWhenCaptionIsGeneratedItHasAuthorName()
    {
        $author = 'Maikel Nait';

        $image = Image::create(
            'providerId',
            'provider',
            'providerUrl',
            'description',
            null,
            1,
            1,
            1,
            1,
            $author,
            []
        );
        $hashTags = ['hasTag1', 'hashTag2'];

        $image->generateCaption(
            new Caption('Caption text', 'en_US'),
            $hashTags
        );

        $this->assertStringContainsString($author, $image->caption());
    }

    public function testWhenCaptionIsGeneratedItHasCaptionText()
    {
        $captionText = 'Cool phrase';

        $image = Image::create(
            'providerId',
            'provider',
            'providerUrl',
            'description',
            null,
            1,
            1,
            1,
            1,
            'author',
            []
        );
        $hashTags = ['hasTag1', 'hashTag2'];

        $image->generateCaption(
            new Caption($captionText, 'en_US'),
            $hashTags
        );

        $this->assertStringContainsString($captionText, $image->caption());
    }

    public function testWhenCaptionIsGeneratedItHasTagsWithHash()
    {
        $image = Image::create(
            'providerId',
            'provider',
            'providerUrl',
            'description',
            null,
            1,
            1,
            1,
            1,
            'author',
            []
        );
        $tag1 = 'tag1';
        $tag2 = 'tag2';
        $tags = [$tag1, $tag2];

        $image->generateCaption(
            new Caption('Cool phrase', 'en_US'),
            $tags
        );

        $this->assertStringContainsString('#' . $tag1, $image->caption());
        $this->assertStringContainsString('#' . $tag2, $image->caption());
    }
}