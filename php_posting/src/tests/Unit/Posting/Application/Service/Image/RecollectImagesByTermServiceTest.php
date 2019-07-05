<?php


namespace Tests\Unit\Posting\Application\Service\Image;


use PHPUnit\Framework\TestCase;
use App\Posting\Application\Service\Image\RecollectImagesByTermRequest;
use App\Posting\Application\Service\Image\RecollectImagesByTermService;
use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageProvider;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\ImageStorage;

class RecollectImagesByTermServiceTest extends TestCase
{
    public function testWhenImagesAreProvidedTheyWillBeStored()
    {
        $imageRepo = $this->createMock(ImageRepository::class);

        $imageStorage = $this->createMock(ImageStorage::class);
        $imageStorage->method('store')->willReturn('path');
        $images = [
            $this->createMock(Image::class),
            $this->createMock(Image::class),
            $this->createMock(Image::class)
        ];
        $imageRepo->expects($this->exactly(count($images)))->method('save');

        $imageProvider = $this->createMock(ImageProvider::class);
        $imageProvider
            ->method('byTerm')
            ->willReturn($images);
        
        $service = new RecollectImagesByTermService($imageRepo, $imageProvider, $imageStorage);

        $service->execute(
            new RecollectImagesByTermRequest('barcelona')
        );
    }
}