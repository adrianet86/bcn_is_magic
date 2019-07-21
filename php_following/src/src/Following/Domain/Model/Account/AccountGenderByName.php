<?php


namespace App\Following\Domain\Model\Account;


interface AccountGenderByName
{
    public function detectGender(string $name): ?string;
}