<?php


namespace App\Posting\Infrastructure\Api\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\PostImage;
use App\Posting\Domain\Model\Image\UnableToPostImageException;
use InstagramAPI\Instagram;
use InstagramAPI\Media\Photo\InstagramPhoto;

class IgPostImage implements PostImage
{
    private Instagram $ig;
    private string $username;
    private string $password;

    public function __construct(array $config, bool $debug, bool $truncatedDebug, string $username, string $password)
    {
        $this->ig = new Instagram(
            $debug,
            $truncatedDebug,
            $config
        );
        $this->username = $username;
        $this->password = $password;
    }

    public function postImage(Image $image, ?string $tmpImagePath): void
    {
        try {
            $imagePath = $image->path();
            if (!is_null($tmpImagePath)) {
                $imagePath = $tmpImagePath;
            }

            $this->ig->login($this->username, $this->password);
            $photo = new InstagramPhoto($imagePath);

            $this->ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $image->caption()]);

            // Delete temporal file
            if (!is_null($tmpImagePath)) {
                unlink($tmpImagePath);
            }

        } catch (\Exception $exception) {
            throw new UnableToPostImageException('UNABLE TO POST IMAGE: ' . $exception->getMessage());
        }
    }
}