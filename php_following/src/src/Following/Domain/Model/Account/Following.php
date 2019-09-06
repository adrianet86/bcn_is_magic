<?php


namespace App\Following\Domain\Model\Account;


interface Following
{
    public function followAccount(Account $account): void;

    public function unfollowAccount(Account $account): void;

    public function login(): void;
}