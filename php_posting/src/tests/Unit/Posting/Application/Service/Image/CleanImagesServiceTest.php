<?php


namespace Unit\Posting\Application\Service\Image;


use App\Posting\Application\Service\Image\CleanImagesService;
use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\ImageStorage;
use App\Posting\Domain\Model\Tag\Tag;
use App\Posting\Domain\Model\Tag\TagRepository;
use PHPUnit\Framework\TestCase;

class CleanImagesServiceTest extends TestCase
{
    private $path;
    private $filePath;

    public function setUp(): void
    {
//        $this->path = __DIR__ . '/../../../../../../var/tmp_images/';
//        $this->filePath = $this->path . 'image.jpg';
//        $image = 'https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80';
//        $imageTemp = file_get_contents($image);
//        file_put_contents($this->filePath, $imageTemp);
    }

    public function tearDown(): void
    {
//        exec('rm -rf ' . $this->path . '*');
    }

    public function testWhenItHasAnExcludingTagItIsDiscarded()
    {
        $excludingTag = 'exclude';
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
            [$excludingTag],
            );
        $imageRepository = $this->createMock(ImageRepository::class);
        $imageRepository
            ->method('unprocessed')
            ->willReturn([$image]);
        $tagRepository = $this->createMock(ImageStorage::class);
        $tagRepository
            ->method('allExcluding')
            ->willReturn([$excludingTag]);
        $service = new CleanImagesService(
            $imageRepository,
            $tagRepository,
            $this->createMock(TagRepository::class)
        );

        $service->execute($image);

        $this->assertTrue($image->isDiscarded());
    }

    public function testWhenItHasNotAnyRequiredTagItIsDiscarded()
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
            [CleanImagesService::MAIN_TAG, 'no_required_tag'],
            );
        $imageRepository = $this->createMock(ImageRepository::class);
        $imageRepository
            ->method('unprocessed')
            ->willReturn([$image]);
        $tagRepository = $this->createMock(TagRepository::class);
        $tagRepository
            ->method('allNonExcluding')
            ->willReturn([new Tag('required_tag', false)]);

        $service = new CleanImagesService(
            $imageRepository,
            $this->createMock(ImageStorage::class),
            $tagRepository
        );

        $service->execute($image);

        $this->assertTrue($image->isDiscarded());
    }

    public function testWhenImageIsDiscardedImageIsRemovedFromStorage()
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
            ['no_main_tag'],
            );
        $imageRepository = $this->createMock(ImageRepository::class);
        $imageRepository
            ->method('unprocessed')
            ->willReturn([$image]);
        $imageStorage = $this->createMock(ImageStorage::class);
        $imageStorage
            ->expects($this->once())
            ->method('remove')
            ->with($image);

        $service = new CleanImagesService(
            $imageRepository,
            $imageStorage,
            $this->createMock(TagRepository::class)
        );

        $service->execute($image);
    }

    public function testWhenImageRatioIsWrongItIsDiscarded()
    {
        $this->markTestSkipped('TODO');
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
            ['no_main_tag'],
            );
        $image = $this->createMock(Image::class);
        $image
            ->method('path')
            ->willReturn($this->filePath);
        $image
            ->expects($this->once())
            ->method('setIsDiscarded')
            ->with(true);

        $imageRepository = $this->createMock(ImageRepository::class);
        $imageRepository
            ->method('unprocessed')
            ->willReturn([$image]);

        $service = new CleanImagesService(
            $imageRepository,
            $this->createMock(ImageStorage::class),
            $this->createMock(TagRepository::class)
        );

        $service->execute($image);
    }
}