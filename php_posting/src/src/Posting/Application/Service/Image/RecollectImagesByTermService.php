<?php


namespace App\Posting\Application\Service\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageNotFoundException;
use App\Posting\Domain\Model\Image\ImageProvider;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\ImageStorage;

class RecollectImagesByTermService
{
    const GAP = 100;

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
        $total = $this->imageProvider->totalByTerm($request->term()) + self::GAP;

        for ($page = 1; ($page * self::GAP) <= $total; $page++) {
            $images = $this->imageProvider->byTerm($request->term(), $page, self::GAP);

            if (!empty($images)) {
                /** @var Image $image */
                foreach ($images as $image) {
                    try {
                        $this->imageRepository->byProvider($image->provider(), $image->providerId());
                    } catch (ImageNotFoundException $exception) {
                        $this->imageStorage->store($image);
                        $this->imageRepository->save($image);
                    }
                }
            }
        }
    }
}