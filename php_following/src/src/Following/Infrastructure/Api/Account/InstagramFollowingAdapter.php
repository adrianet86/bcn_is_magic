<?php


namespace App\Following\Infrastructure\Api\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\Following;
use InstagramAPI\Instagram;

class InstagramFollowingAdapter implements Following
{
    const WAIT = 5;

    private Instagram $ig;
    private string $username;
    private string $password;

    public function __construct(
        array $config,
        bool $debug,
        bool $truncatedDebug,
        string $username,
        string $password
    )
    {
        $this->ig = new Instagram(
            $debug,
            $truncatedDebug,
            $config
        );
        $this->username = $username;
        $this->password = $password;
    }

    public function followAccount(Account $account): void
    {
        $this->ig->login($this->username, $this->password);
        sleep(self::WAIT);
        $this->ig->people->follow($account->instagramId());
        $account->setFollowingRequestedAt();
    }

    public function unfollowAccount(Account $account): void
    {
        $this->ig->login($this->username, $this->password);
        sleep(self::WAIT);
        $this->ig->people->unfollow($account->instagramId());
    }
}