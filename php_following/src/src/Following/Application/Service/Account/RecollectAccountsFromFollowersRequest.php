<?php


namespace App\Following\Application\Service\Account;


class RecollectAccountsFromFollowersRequest
{
    private string $accountUsername;

    public function __construct(string $accountUsername)
    {
        $this->accountUsername = $accountUsername;
    }

    public function accountUsername(): string
    {
        return $this->accountUsername;
    }
}