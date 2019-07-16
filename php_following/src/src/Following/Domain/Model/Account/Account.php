<?php


namespace App\Following\Domain\Model\Account;


use Ramsey\Uuid\Uuid;

class Account
{
    private string $id;
    private int $followBack;
    private string $fromAccount;
    private string $fromMethod;
    private \DateTimeImmutable $createdAt;
    // IG info
    private string $instagramId;
    private string $username;
    private string $name;
    private bool $isPrivate;
    private bool $hasProfilePicture;
    private bool $isBusiness;
    private int $followers;
    private int $following;
    private string $biography;
    private int $mediaCount;

    private $gender;// TODO: find a way to predict gender

    private function __construct(
        string $fromAccount,
        string $fromMethod,
        string $instagramId,
        string $username,
        string $name,
        bool $isPrivate,
        bool $hasProfilePicture,
        bool $isBusiness,
        int $followers,
        int $following,
        string $biography,
        int $mediaCount
    )
    {
        $this->id = Uuid::uuid4()->toString();
        $this->createdAt = new \DateTimeImmutable();
        $this->fromAccount = $fromAccount;
        $this->fromMethod = $fromMethod;
        $this->instagramId = $instagramId;
        $this->username = $username;
        $this->name = $name;
        $this->isPrivate = $isPrivate;
        $this->hasProfilePicture = $hasProfilePicture;
        $this->isBusiness = $isBusiness;
        $this->followers = $followers;
        $this->following = $following;
        $this->biography = $biography;
        $this->mediaCount = $mediaCount;
    }

    public static function create(
        string $fromAccount,
        string $fromMethod,
        string $instagramId,
        string $username,
        string $name,
        bool $isPrivate,
        bool $hasProfilePicture,
        bool $isBusiness,
        int $followers,
        int $following,
        string $biography,
        int $mediaCount
    ): self
    {
        return new self(
            $fromAccount,
            $fromMethod,
            $instagramId,
            $username,
            $name,
            $isPrivate,
            $hasProfilePicture,
            $isBusiness,
            $followers,
            $following,
            $biography,
            $mediaCount
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function followBack()
    {
        return $this->followBack;
    }

    public function fromAccount()
    {
        return $this->fromAccount;
    }

    public function fromMethod()
    {
        return $this->fromMethod;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function instagramId()
    {
        return $this->instagramId;
    }

    public function username()
    {
        return $this->username;
    }

    public function name()
    {
        return $this->name;
    }

    public function isPrivate()
    {
        return $this->isPrivate;
    }

    public function hasProfilePicture()
    {
        return $this->hasProfilePicture;
    }

    public function isBusiness()
    {
        return $this->isBusiness;
    }

    public function followers()
    {
        return $this->followers;
    }

    public function following()
    {
        return $this->following;
    }

    public function biography()
    {
        return $this->biography;
    }

    public function mediaCount()
    {
        return $this->mediaCount;
    }

    public function followerRatio()
    {
        return $this->following / $this->followers;
    }

    public function gender()
    {
        return $this->gender;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setIsPrivate(bool $isPrivate)
    {
        $this->isPrivate = $isPrivate;
    }

    public function setHasProfilePicture(bool $hasProfilePicture)
    {
        $this->hasProfilePicture = $hasProfilePicture;
    }

    public function setIsBusiness(bool $isBusiness)
    {
        $this->isBusiness = $isBusiness;
    }

    public function setFollowers(int $followers)
    {
        $this->followers = $followers;
    }

    public function setFollowing(int $following)
    {
        $this->following = $following;
    }

    public function setBiography(string $biography)
    {
        $this->biography = $biography;
    }

    public function setMediaCount(int $mediaCount)
    {
        $this->mediaCount = $mediaCount;
    }
}