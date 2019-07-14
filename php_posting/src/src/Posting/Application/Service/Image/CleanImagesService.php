<?php


namespace App\Posting\Application\Service\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Image\ImageStorage;
use App\Posting\Domain\Model\Tag\Tag;
use App\Posting\Domain\Model\Tag\TagRepository;

class CleanImagesService
{
    const MAIN_TAG = 'barcelona';
    const MAX_RATIO = 1.910;
    const MIN_RATIO = 0.800;

    private ImageRepository $imageRepository;
    private ImageStorage $imageStorage;
    private TagRepository $tagRepository;

    public function __construct(
        ImageRepository $imageRepository,
        ImageStorage $imageStorage,
        TagRepository $tagRepository
    )
    {
        $this->imageRepository = $imageRepository;
        $this->imageStorage = $imageStorage;
        $this->tagRepository = $tagRepository;
    }

    public function execute($request = null): void
    {
        $images = $this->imageRepository->unprocessed();
        /** @var Image $image */
        foreach ($images as $image) {
            if (empty($image->tags())) {
                $image->setIsDiscarded(true);
            }
            $this->discardByImageRatio($image);
            $this->discardByExcludingTags($image);
            $this->discardByRequiredTags($image);

            if ($image->isDiscarded() === true) {
                $this->imageStorage->remove($image);
            }

            $this->imageRepository->save($image);
        }
    }

    private function discardByRequiredTags(Image $image): void
    {
        if ($image->isDiscarded() === null) {
            $requiredTags = $this->tagRepository->allNonExcluding();
            if (!empty($requiredTags)) {
                /** @var Tag $requiredTag */
                foreach ($requiredTags as $requiredTag) {
                    if (in_array($requiredTag->tag(), $image->tags())) {
                        $image->setIsDiscarded(false);
                        return;
                    }
                }
            }

            $image->setIsDiscarded(true);
        }
        return;
    }

    private function discardByExcludingTags(Image $image): void
    {
        if ($image->isDiscarded() === null) {
            $requiredTags = $this->tagRepository->allExcluding();
            if (!empty($requiredTags)) {
                /** @var Tag $requiredTag */
                foreach ($requiredTags as $requiredTag) {
                    if (in_array($requiredTag->tag(), $image->tags())) {
                        $image->setIsDiscarded(true);
                        return;
                    }
                }
            }
        }
        return;
    }

    private function discardByImageRatio(Image $image): void
    {
        if ($image->isDiscarded() !== true) {
            $imageSize = getimagesize($image->path());
            $width = $imageSize[0];
            $height = $imageSize[1];
            $ratio = $width / $height;
            if ($ratio < self::MIN_RATIO || $ratio > self::MAX_RATIO) {
                $image->setIsDiscarded(true);
                return;
            }
        }
        return;
    }
}