<?php


namespace App\Following\Infrastructure\Api\Account;


use App\Following\Domain\Model\Account\Account;
use App\Following\Domain\Model\Account\AccountProvider;
use InstagramAPI\Instagram;
use InstagramAPI\Response\Model\User;

class InstagramAccountProviderAdapter implements AccountProvider
{
    const METHOD = 'follower';
    const PAGE_SIZE = 200;
    const WAIT = 3;

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

    public function byAccountFollowers(string $accountUsername, int $page): array
    {
        $this->ig->login($this->username, $this->password);

        $perPage = self::PAGE_SIZE;
        $rankToken = \InstagramAPI\Signatures::generateUUID();
        $userInfo = $this->ig->people->getInfoByName($accountUsername)->getUser();
        $maxId = $this->getMaxId($userInfo, $page, $perPage, $rankToken);
        $accounts = [];

        $followerResponse = $this->ig->people->getFollowers($userInfo->getPk(), $rankToken, null, $maxId);
        $followers = $followerResponse->getUsers();

        if (!empty($followers)) {
            /** @var User $follower */
            foreach ($followers as $follower) {
                $user = $this->ig->people->getInfoByName($follower->getUsername())->getUser();

                $accounts[] = Account::create(
                    $accountUsername,
                    self::METHOD,
                    $user->getPk(),
                    $user->getUsername(),
                    $user->getFullName(),
                    $user->isIsPrivate(),
                    !empty($user->getProfilePicId()),
                    $user->getIsBusiness(),
                    $user->getFollowerCount(),
                    $user->getFollowingCount(),
                    $user->getBiography(),
                    $user->getMediaCount()
                );
                echo "zzZZZZZZzzzz sleep to give rest to api zzzzzZZZZZZzzzz\n";
                sleep(self::WAIT);
            }
        }

        return $accounts;
    }

    public function totalByAccountFollowers(string $accountUsername): int
    {
        $this->ig->login($this->username, $this->password);
        $user = $this->ig->people->getInfoByName($accountUsername)->getUser();

        return $user->getFollowerCount();
    }

    private function getMaxId(User $user, int $page, int $perPage, string $rankToken)
    {
        $maxId = null;
        $followers = $user->getFollowerCount();
        $startPosition = ($page - 1) * $perPage;

        if ($followers <= 0) {
            throw new \Exception('NO FOLLOWERS');
        }
        if ($page == 1) {
            return $maxId;
        }
        if ($startPosition > $followers) {
            throw new \Exception('PAGE OUT OF RANGE');
        }

        $igPosition = 1;

        do {
            $followerResponse = $this->ig->people->getFollowers($user->getPk(), $rankToken, null, $maxId);
            $igPosition += count($followerResponse->getUsers());
            $maxId = $followerResponse->getNextMaxId();
        } while ($igPosition < $startPosition);

        return $maxId;
    }
}