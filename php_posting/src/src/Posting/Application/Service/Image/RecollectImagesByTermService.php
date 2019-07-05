<?php


namespace App\Posting\Application\Service\Image;


use App\Posting\Domain\Model\Image\ImageProvider;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\ImageStorage;

class RecollectImagesByTermService
{
    private ImageRepository $imageRepository;
    private ImageProvider $imageProvider;
    private ImageStorage $imageStorage;

    public function __construct(
        ImageRepository $imageRepository,
        ImageProvider $imageProvider,
        ImageStorage $imageStorage
    )
    {
        $this->imageRepository = $imageRepository;
        $this->imageProvider = $imageProvider;
        $this->imageStorage = $imageStorage;
    }

    /**
     * @param RecollectImagesByTermRequest $request
     */
    public function execute($request = null)
    {
        $images = $this->imageProvider->byTerm($request->term());

        if (!empty($images)) {
            foreach ($images as $image) {
                $this->imageStorage->store($image);
                $this->imageRepository->save($image);
            }
        }
    }
}