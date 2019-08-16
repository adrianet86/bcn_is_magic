<?php


namespace App\Posting\Application\Service\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageNotFoundException;
use App\Posting\Domain\Model\Image\ImageProviderFactory;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\ImageStorage;

class RecollectImagesByTermService
{
    const PER_PAGE = 100;

    private ImageRepository $imageRepository;
    private ImageProviderFactory $imageProviderFactory;
    private ImageStorage $imageStorage;

    public function __construct(
        ImageRepository $imageRepository,
        ImageProviderFactory $imageProviderFactory,
        ImageStorage $imageStorage
    )
    {
        $this->imageRepository = $imageRepository;
        $this->imageProviderFactory = $imageProviderFactory;
        $this->imageStorage = $imageStorage;
    }

    /**
     * @param RecollectImagesByTermRequest $request
     * @throws \App\Posting\Domain\Model\Image\ImageProviderNotFoundException
     */
    public function execute($request = null)
    {
        $imageProvider = $this->imageProviderFactory->byName($request->provider());
        $total = $imageProvider->totalByTerm($request->term()) + self::PER_PAGE;
        $totalRepo = $this->imageRepository->totalByProvider($request->provider());
        if ($totalRepo < self::PER_PAGE) {
            $page = 1;
        } else {
            $page = (int)round($totalRepo / self::PER_PAGE);
        }
        for ($page; ($page * self::PER_PAGE) <= $total; $page++) {
            $images = $imageProvider->byTerm($request->term(), $page, self::PER_PAGE);
            if (!empty($images)) {
                /** @var Image $image */
                foreach ($images as $image) {
                    try {
                        // TODO: update if exists.
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