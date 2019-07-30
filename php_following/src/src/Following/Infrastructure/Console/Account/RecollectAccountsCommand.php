<?php


namespace App\Following\Infrastructure\Console\Account;


use App\Following\Application\Service\Account\RecollectAccountsFromFollowersRequest;
use App\Following\Application\Service\Account\RecollectAccountsFromFollowersService;
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
            new RecollectAccountsFromFollowersRequest('xopet1969')
        );

        $output->writeln('FINISH - ' . strtoupper(self::$defaultName) . ': ' . (string)(microtime(true) - $time));
    }

    private $list = [
        'nicanorgarcia',//745
        'barcelonacitizen',//246
        'stoptheroc',//153
        'neburruben',//129
        'thebarcelonist',//75
        'seojmi',//65,3
        'bcnfoodieguide',//48,7
        'zuckerandspice',//46,9
        'xopet1969', //16,4
    ];
}