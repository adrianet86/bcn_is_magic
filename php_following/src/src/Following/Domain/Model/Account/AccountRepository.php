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
}