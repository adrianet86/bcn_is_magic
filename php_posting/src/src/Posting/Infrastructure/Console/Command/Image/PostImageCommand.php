<?php


namespace App\Posting\Infrastructure\Console\Command\Image;


use App\Posting\Application\Service\Image\PostImageRequest;
use App\Posting\Domain\Model\Image\ImageRepository;
use App\Posting\Application\Service\Image\PostImageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostImageCommand extends Command
{
    private PostImageService $postImageService;
    private ImageRepository $imageRepository;

    protected static $defaultName = 'post-image';

    protected function configure()
    {
        $this
            ->setDescription('Post random image to IG.')
            ->setHelp('This command post a random image to IG account.');
    }

    public function __construct(PostImageService $postImageService, ImageRepository $imageRepository)
    {
        $this->postImageService = $postImageService;
        $this->imageRepository = $imageRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $offset = 1;
        $limit = 1;
        $images = $this->imageRepository->notPosted($offset, $limit);
        if (!empty($images)) {
            $image = $images[0];
            $this->postImageService->execute(
                new PostImageRequest($image->id())
            );
        }
    }
}