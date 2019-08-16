<?php


namespace App\Posting\Infrastructure\Console\Command\Image;


use App\Posting\Application\Service\Image\RecollectImagesByTermRequest;
use App\Posting\Application\Service\Image\RecollectImagesByTermService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecollectImagesCommand extends Command
{
    private RecollectImagesByTermService $recollectImagesByTermService;

    protected static $defaultName = 'recollect-images';

    protected function configure()
    {
        $this
            ->addArgument(
                'provider',
                InputArgument::REQUIRED,
                'Name of the image provider',
                'unsplash'
            )
            ->setDescription('Get images from a provider.')
            ->setHelp('This command download images from providers and store them in our system');
    }

    public function __construct(RecollectImagesByTermService $recollectImagesByTermService)
    {
        $this->recollectImagesByTermService = $recollectImagesByTermService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Europe/Madrid'));
        $output->writeln('START - ' . strtoupper(self::$defaultName) . ': ' . $dt->format('Y-m-d H:i:s'));
        $time = microtime(true);

        $this->recollectImagesByTermService->execute(
            new RecollectImagesByTermRequest('barcelona', $input->getArgument('provider'))
        );

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }
}