<?php


namespace App\Following\Infrastructure\Console\Account;


use App\Following\Application\Service\Account\CalculateFollowingRatingService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateFollowingRatingCommand  extends Command
{
    protected static $defaultName = 'calculate-following-rating';

    private CalculateFollowingRatingService $calculateFollowingRatingService;

    protected function configure()
    {
        $this
            ->setDescription('Calculaes again following rating.');
    }

    public function __construct(
        CalculateFollowingRatingService  $calculateFollowingRatingService
    )
    {
        $this->calculateFollowingRatingService = $calculateFollowingRatingService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Europe/Madrid'));
        $output->writeln('START - ' . strtoupper(self::$defaultName) . ': ' . $dt->format('Y-m-d H:i:s'));
        $time = microtime(true);

        $this->calculateFollowingRatingService->execute();

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }
}