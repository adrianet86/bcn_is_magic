<?php


namespace App\Following\Application\Service\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountRepository;
use Doctrine\ORM\EntityManager;

class CalculateFollowingRatingService
{
    private AccountRepository $accountRepository;
    private EntityManager $entityManager;

    public function __construct(
        AccountRepository $accountRepository,
        EntityManager $entityManager
    )
    {
        $this->accountRepository = $accountRepository;
        $this->entityManager = $entityManager;
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
                $this->entityManager->persist($account);
            }
            $this->entityManager->flush();
        }
    }
}