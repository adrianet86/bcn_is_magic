<?php


namespace App\Posting\Application\Service\Image;


use App\Posting\Domain\Model\Caption\CaptionRepository;
use App\Posting\Domain\Model\Caption\LocaleNotFoundException;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Domain\Model\Tag\TagRepository;

class GenerateImageCaptionService
{
    private ImageRepository $imageRepository;
    private CaptionRepository $captionRepository;
    private TagRepository $tagRepository;

    public function __construct(
        ImageRepository $imageRepository,
        CaptionRepository $captionRepository,
        TagRepository $tagRepository
    )
    {
        $this->imageRepository = $imageRepository;
        $this->captionRepository = $captionRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param GenerateImageCaptionRequest $request
     * @throws LocaleNotFoundException
     */
    public function execute($request): void
    {
        $caption = $this->captionRepository->rand(null);
        $tags = $this->tagRepository->hashTags();

        $image = $this->imageRepository->byId($request->imageId());

        $image->generateCaption($caption, $tags);

        if (empty($image->caption())) {
            throw new \Exception('NO CAPTION');
        }

        $this->imageRepository->save($image);
    }
}