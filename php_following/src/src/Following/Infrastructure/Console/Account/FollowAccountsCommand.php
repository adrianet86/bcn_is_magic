<?php


namespace App\Following\Infrastructure\Console\Account;


use App\Following\Application\Service\Account\FollowAccountsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FollowAccountsCommand extends Command
{
    protected static $defaultName = 'follow-accounts';

    private FollowAccountsService $followAccountsService;

    protected function configure()
    {
        $this
            ->setDescription('Follows a max number of 400 accounts');
    }

    public function __construct(
        FollowAccountsService $followAccountsService
    )
    {
        $this->followAccountsService = $followAccountsService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Europe/Madrid'));
        $output->writeln('START - ' . strtoupper(self::$defaultName) . ': ' . $dt->format('Y-m-d H:i:s'));
        $time = microtime(true);

        $this->followAccountsService->execute();

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }
}