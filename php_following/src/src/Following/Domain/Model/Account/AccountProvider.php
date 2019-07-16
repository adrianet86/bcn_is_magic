<?php


namespace App\Following\Domain\Model\Account;


interface AccountProvider
{
    public function byAccountFollowers(string $accountUsername, int $page, int $perPage): array;

    public function totalByAccountFollowers(string $accountUsername): int;
}