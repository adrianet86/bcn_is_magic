<?php


namespace App\Following\Infrastructure\Console\Account;


use App\Following\Application\Service\Account\UnfollowAccountsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnfollowAccountsCommand extends Command
{
    protected static $defaultName = 'unfollow-accounts';

    private UnfollowAccountsService $unfollowAccountsService;

    protected function configure()
    {
        $this
            ->setDescription('Unfollow accounts requested two days ago');
    }

    public function __construct(
        UnfollowAccountsService $unfollowAccountsService
    )
    {
        $this->unfollowAccountsService = $unfollowAccountsService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Europe/Madrid'));
        $output->writeln('START - ' . strtoupper(self::$defaultName) . ': ' . $dt->format('Y-m-d H:i:s'));
        $time = microtime(true);

        $this->unfollowAccountsService->execute();

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }
}