<?php


namespace App\Following\Infrastructure\Persistance\Doctrine\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountExistsWithSameUsernameException;
use App\Following\Domain\Model\Account\AccountNotFoundException;
use App\Following\Domain\Model\Account\AccountRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineAccountRepository implements AccountRepository
{
    private EntityManager $entityManager;

    private EntityRepository $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Account::class);
    }

    /**
     * @param Account $account
     * @throws AccountExistsWithSameUsernameException
     */
    private function assertNotExistsWithSameUsername(Account $account): void
    {
        try {
            $entity = $this->byUsername($account->username());
            if ($entity->id() !== $account->id()) {
                throw new AccountExistsWithSameUsernameException('ACCOUNT WITH SAME USERNAME: ' . $account->username());
            }
            return;
        } catch (AccountNotFoundException $exception) {
            return;
        }
    }

    /**
     * @param Account $account
     * @throws AccountExistsWithSameUsernameException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(Account $account): void
    {
        $this->assertNotExistsWithSameUsername($account);
        $this->entityManager->persist($account);
        $this->entityManager->flush($account);
    }

    /**
     * @param string $username
     * @return Account
     * @throws AccountNotFoundException
     */
    public function byUsername(string $username): Account
    {
        $entity = $this->repository->findOneBy([
            'username' => $username
        ]);

        if ($entity instanceof Account) {
            return $entity;
        }

        throw new AccountNotFoundException('ACCOUNT NOT FOUND FOR USERNAME: ' . $username);
    }

    /**
     * @param int $size
     * @return array
     */
    public function accountsToFollowOrderedByRating(int $size = 400): array
    {
        $entities = $this->repository->findBy(
            [
                'followingRequestedAt' => null
            ],
            [
                'followingRating' => 'desc'
            ],
            $size
        );

        return $entities;
    }
}