<?php


namespace App\Following\Domain\Model\Account;


interface AccountRepository
{
    /**
     * @param Account $account
     * @throws AccountExistsWithSameUsernameException
     */
    public function store(Account $account): void;

    /**
     * @param string $username
     * @return Account
     * @throws AccountNotFoundException
     */
    public function byUsername(string $username): Account;

    /**
     * @param int $size
     * @return array
     */
    public function accountsToFollowOrderedByRating(int $size = 400): array;

    public function totalByFromAccount(string $accountUsername): int;

    public function byFollowingRequestSentBetween(\DateTime $from, \DateTime $to): array;
}