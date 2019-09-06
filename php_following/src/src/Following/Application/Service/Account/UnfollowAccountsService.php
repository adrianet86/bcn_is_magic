<?php


namespace App\Following\Application\Service\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountRepository;
use App\Following\Infrastructure\Api\Account\InstagramFollowingAdapter;

class UnfollowAccountsService
{
    private const WAIT_TIME = 15;

    private AccountRepository $accountRepository;
    private InstagramFollowingAdapter $followingAdapter;

    public function __construct(
        AccountRepository $accountRepository,
        InstagramFollowingAdapter $followingAdapter
    )
    {
        $this->accountRepository = $accountRepository;
        $this->followingAdapter = $followingAdapter;
    }

    public function execute($request = null): void
    {
        $from = new \DateTime('2 days ago');
        $to = new \DateTime('1 day ago');
        $accountsToUnfollow = $this->accountRepository->byFollowingRequestSentBetween($from, $to);

        foreach ($accountsToUnfollow as $account) {
            $this->unfollow($account);
            sleep(self::WAIT_TIME);
        }
    }

    private function unfollow(Account $account): void
    {
        try {
            $this->followingAdapter->unfollowAccount($account);
        } catch (\Exception $exception) {

        }
    }
}