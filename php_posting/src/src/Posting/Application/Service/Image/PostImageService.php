<?php


namespace App\Posting\Application\Service\Image;


use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\PostImage;

class PostImageService
{
    /**
     * @var PostImage $postImage
     */
    private PostImage $postImage;
    /**
     * @var ImageRepository $imageRepository
     */
    private ImageRepository $imageRepository;
    /**
     * @var GenerateImageCaptionService $generateImageCaptionService
     */
    private GenerateImageCaptionService $generateImageCaptionService;

    public function __construct(
        PostImage $postImage,
        ImageRepository $imageRepository,
        GenerateImageCaptionService $generateImageCaptionService
    )
    {
        $this->postImage = $postImage;
        $this->imageRepository = $imageRepository;
        $this->generateImageCaptionService = $generateImageCaptionService;
    }

    public function execute($request)
    {
        $image = $this->imageRepository->byId($request->imageId());

        $this->generateImageCaptionService->execute(new GenerateImageCaptionRequest($request->imageId()));

        $this->postImage->postImage($image, null);

        $this->imageRepository->save($image);
    }
}