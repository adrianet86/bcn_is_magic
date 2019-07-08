<?php


namespace Tests\Unit\Posting\Infrastructure\File\Image;


use PHPUnit\Framework\TestCase;
use App\Posting\Domain\Model\Image\Image;
use App\Posting\Infrastructure\File\Image\FileImageStorage;

class FileImageStorageTest extends TestCase
{
    /** @var FileImageStorage */
    private FileImageStorage $fileImageStorage;
    private string $path;

    public function setUp(): void
    {
        $this->path = __DIR__ . '/../../../../../../var/tmp_images/';
        $this->fileImageStorage = new FileImageStorage($this->path, true);
    }

    public function tearDown(): void
    {
        exec('rm -rf ' . $this->path . '*' );
    }

    public function testWhenImageWithProviderUrlItStoresAnImageInLocalFile()
    {
        $provider = 'provider';
        $providerId = 'fake_id';
        $expectedImagePath = $this->path . $provider . '_' . $providerId . '.jpeg';
        $image = $this->createMock(Image::class);
        $image
            ->method('providerUrl')
            ->willReturn('https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80');
        $image
            ->method('providerId')
            ->willReturn($providerId);
        $image
            ->method('provider')
            ->willReturn($provider);

        $image
            ->expects($this->once())
            ->method('setPath')
            ->with($expectedImagePath);

        $this->fileImageStorage->store($image);
    }
}