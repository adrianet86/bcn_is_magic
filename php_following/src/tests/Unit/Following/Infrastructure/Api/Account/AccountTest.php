<?php


namespace Unit\Following\Infrastructure\Api\Account;


use App\Following\Domain\Model\Account\Account;
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

    public function testRatingIsBadWhenAnyFieldIsGood()
    {
        $account = Account::create(
            'from',
            'method',
            'id',
            'username',
            'name',
            false,
            false,
            false,
            0,
            0,
            'hi',
            0
        );

        $this->assertEquals(0, $account->followingRating());
    }

    public function testWhenAccountIsNotPrivateItHasGoodRating()
    {
        $account = Account::create(
            'from',
            'method',
            'id',
            'username',
            'name',
            true,
            false,
            false,
            0,
            0,
            'hi',
            0
        );

        $this->assertNotEquals(0, $account->followingRating());
    }

    public function testWhenAccountHasProfilePictureItHasGoodRating()
    {
        $account = Account::create(
            'from',
            'method',
            'id',
            'username',
            'name',
            false,
            true,
            false,
            0,
            0,
            'hi',
            0
        );

        $this->assertNotEquals(0, $account->followingRating());
    }

    public function testWhenAccountHasGoodFollowingRatioItHasGoodRating()
    {
        $account = Account::create(
            'from',
            'method',
            'id',
            'username',
            'name',
            false,
            false,
            false,
            10,
            5,
            'hi',
            0
        );

        $this->assertNotEquals(0, $account->followingRating());
    }

}