<?php


namespace App\Following\Domain\Model\Account;


interface AccountProvider
{
    /**
     * Max elements by page = 200
     *
     * @param string $accountUsername
     * @param int $page
     * @return array
     */
    public function byAccountFollowers(string $accountUsername, int $page): array;

    public function totalByAccountFollowers(string $accountUsername): int;
}