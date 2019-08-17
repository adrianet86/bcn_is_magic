<?php


namespace App\Following\Application\Service\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountRepository;

class CalculateFollowingRatingService
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute($request = null): void
    {
        $perPage = 100;
        $total = $this->accountRepository->totalNotRequested();
        if ($total < $perPage) {
            $totalPages = 1;
        } else {
            $totalPages = $total / $perPage;
        }

        for ($page = 1; $page <= $totalPages; $page++) {
            $accounts = $this->accountRepository->allNotRequested($page, $perPage);
            /** @var Account $account */
            foreach ($accounts as $account) {
                $account->updateFollowingRating();
                $this->accountRepository->store($account);
            }
        }
    }
}