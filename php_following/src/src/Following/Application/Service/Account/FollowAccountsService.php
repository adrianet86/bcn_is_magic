<?php


namespace App\Following\Application\Service\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountRepository;
use App\Following\Domain\Model\Account\Following;

class FollowAccountsService
{
    const WAIT = 2;

    private AccountRepository $accountRepository;
    private Following $following;

    public function __construct(
        AccountRepository $accountRepository,
        Following $following
    )
    {
        $this->accountRepository = $accountRepository;
        $this->following = $following;
    }

    public function execute($request = null): void
    {
        $accountsToFollow = $this->accountRepository->accountsToFollowOrderedByRating();

        if (!empty($accountsToFollow)) {
            /** @var Account $anAccountToFollow */
            foreach ($accountsToFollow as $anAccountToFollow) {
//                echo $anAccountToFollow->name() . ' ' . $anAccountToFollow->followingRating() . "\n";
                $this->following->followAccount($anAccountToFollow);
                $this->accountRepository->store($anAccountToFollow);
                echo "zzzZZZZZzzzzz wait to to give a rest to the api zzzzZZZZZZzzzzzz";
                sleep(self::WAIT);
            }
        }
    }
}