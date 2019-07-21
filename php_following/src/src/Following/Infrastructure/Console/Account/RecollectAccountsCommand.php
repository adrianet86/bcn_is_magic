<?php


namespace App\Following\Infrastructure\Console\Account;


use App\Following\Application\Service\Account\RecollectAccountsFromFollowersRequest;
use App\Following\Application\Service\Account\RecollectAccountsFromFollowersService;
use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecollectAccountsCommand extends Command
{
    protected static $defaultName = 'recollect-accounts';

    private RecollectAccountsFromFollowersService $recollectAccountsService;

    protected function configure()
    {
        $this
            ->setDescription('Get accounts from another account followers.')
            ->setHelp('This command stores followers from other account.');
    }

    public function __construct(
        RecollectAccountsFromFollowersService $recollectAccountsService
    )
    {
        $this->recollectAccountsService = $recollectAccountsService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Europe/Madrid'));
        $output->writeln('START - ' . strtoupper(self::$defaultName) . ': ' . $dt->format('Y-m-d H:i:s'));
        $time = microtime(true);

        $this->recollectAccountsService->execute(
            new RecollectAccountsFromFollowersRequest('adrianet1919')
        );

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }

    private $list = [
        'xopet1969',
        'thebarcelonist',
        'zuckerandspice',
        'nicanorgarcia',
        'piluro',
        'seojmi',
        'stoptheroc',
        'barcelonacitizen',
        'neburruben',
        'bcnfoodieguide',
        'bcnfacades'
    ];
}