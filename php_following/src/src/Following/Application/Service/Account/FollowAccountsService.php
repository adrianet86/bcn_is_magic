<?php


namespace App\Following\Application\Service\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountRepository;
use App\Following\Domain\Model\Account\Following;

class FollowAccountsService
{
    const WAIT = 15;

    private AccountRepository $accountRepository;
    private Following $following;
    private int $followerSize;


    public function __construct(
        AccountRepository $accountRepository,
        Following $following,
        int $followerSize = 400
    )
    {
        $this->accountRepository = $accountRepository;
        $this->following = $following;
        $this->followerSize = $followerSize;
    }

    public function execute($request = null): void
    {
        $accountsToFollow = $this->accountRepository->accountsToFollowOrderedByRating($this->followerSize);

        if (!empty($accountsToFollow)) {
            $this->following->login();
            /** @var $anAccountToFollow Account  */
            foreach ($accountsToFollow as $anAccountToFollow) {
                $this->followAccount($anAccountToFollow);
                $this->accountRepository->store($anAccountToFollow);
                $wait = self::WAIT + rand(1, 4);
                echo "zzzZZZZZzzzzz wait $wait seconds to give a rest to the api zzzzZZZZZZzzzzzz\n";
                sleep($wait);
            }
        }
    }

    private function followAccount(Account $account): void
    {
        try {
            $this->following->followAccount($account);
        } catch (\Exception $exception) {

        }
    }
}