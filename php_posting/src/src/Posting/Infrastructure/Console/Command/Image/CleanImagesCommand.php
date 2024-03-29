<?php


namespace App\Posting\Infrastructure\Console\Command\Image;


use App\Posting\Application\Service\Image\CleanImagesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanImagesCommand extends Command
{
    private CleanImagesService $cleanImagesService;

    protected static $defaultName = 'clean-images';

    protected function configure()
    {
        $this
            ->setDescription('Clean images not useful.')
            ->setHelp('This command process images and discard.');
    }

    public function __construct(CleanImagesService $cleanImagesService)
    {
        $this->cleanImagesService = $cleanImagesService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Europe/Madrid'));
        $output->writeln('START - ' . strtoupper(self::$defaultName) . ': ' . $dt->format('Y-m-d H:i:s'));
        $time = microtime(true);
        $this->cleanImagesService->execute(null);

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }
}