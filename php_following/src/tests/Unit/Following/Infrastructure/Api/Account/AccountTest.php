<?php


namespace Unit\Following\Infrastructure\Api\Account;


use App\Following\Infrastructure\Api\Account\InstagramAccountProviderAdapter;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testCCCC()
    {
        $service = new InstagramAccountProviderAdapter(
            [
                'storage' => 'file',
                'basefolder' => __DIR__ . '/../../../../../../var/ig/'
            ],
            true,
            false,
            'bcn_is_magic',
            'bcn_is_magic_password'
        );

        $accountUsername = 'adrianet1919';
        $accountUsername = 'barcelonacartours';
        $page = 2;

        //$service->byAccountFollowers($accountUsername, $page);
    }

}