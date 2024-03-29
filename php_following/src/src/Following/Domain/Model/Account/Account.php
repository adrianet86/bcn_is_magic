<?php


namespace App\Following\Domain\Model\Account;


use Ramsey\Uuid\Uuid;

class Account
{
    private string $id;
    private string $fromAccount;
    private string $fromMethod;
    private \DateTimeImmutable $createdAt;
    private ?\DateTime $followingRequestedAt;
    private ?int $followBack;
    private ?\DateTime $updatedAt;

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
    private float $followingRating;
    private ?float $followerRatio;
    private ?string $gender;

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
        $this->followBack = null;
        $this->followingRequestedAt = null;
        $this->updatedAt = null;
        $this->gender = null;
        $this->setFollowerRatio();
        $this->followingRating = $this->calculateFollowingRating();
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

    public function fromAccount(): string
    {
        return $this->fromAccount;
    }

    public function fromMethod(): string
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

    public function username(): string
    {
        return $this->username;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function hasProfilePicture(): bool
    {
        return $this->hasProfilePicture;
    }

    public function isBusiness(): bool
    {
        return $this->isBusiness;
    }

    public function followers(): int
    {
        return $this->followers;
    }

    public function following(): int
    {
        return $this->following;
    }

    public function biography(): ?string
    {
        return $this->biography;
    }

    public function mediaCount(): int
    {
        return $this->mediaCount;
    }

    public function setFollowerRatio()
    {
        $this->followerRatio = 0;
        if ($this->following !== 0 && $this->followers !== 0) {
            $this->followerRatio = $this->following / $this->followers;
        }
    }

    public function gender()
    {
        return $this->gender;
    }

    public function followingRequestedAt(): ?\DateTime
    {
        return $this->followingRequestedAt;
    }

    public function updateIgInfo(
        string $name,
        bool $isPrivate,
        bool $hasProfilePicture,
        bool $isBusiness,
        int $followers,
        int $following,
        ?string $biography,
        int $mediaCount
    )
    {
        $this->name = $name;
        $this->isPrivate = $isPrivate;
        $this->isBusiness = $isBusiness;
        $this->hasProfilePicture = $hasProfilePicture;
        $this->following = $following;
        $this->followers = $followers;
        $this->biography = $biography;
        $this->mediaCount = $mediaCount;
        $this->updatedAt = new \DateTime();
    }

    public function updatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    private function calculateFollowingRating(): float
    {
        $rate = 1;
        // I do not want any business account.
        if ($this->isBusiness) {
            $rate *= 0;
        }
        // Follower ratio has a multiplier to increase probability, I understand this variable is more important than others
        if ($this->followerRatio() < 3) {
            $rate *= 0;
        }
        if ($this->isPrivate) {
            $rate *= 0;
        }
        if ($this->hasProfilePicture === false) {
            $rate *= 0;
        }
        if ($this->followers <= 150) {
            $rate *= 0;
        }
        if ($this->following <= 800) {
            $rate *= 0;
        }
        if ($this->mediaCount <= 150) {
            $rate *= 0;
        }

        return $rate;
    }

    public function updateFollowingRating(): void
    {
        $this->followingRating = $this->calculateFollowingRating();
        $this->updatedAt = new \DateTime();
    }

    private function calculateFollowingRatingOld(): float
    {
        $rate = 0;
        // I do not want any business account.
        if ($this->isBusiness) {
            $rate -= 1;
        }
        // Only female accounts adds rating coz we do not have enough info to penalize instead.
        if ($this->gender === 'female') {
            $rate += 0.3;
        }
        // Follower ratio has a multiplier to increase probability, I understand this variable is more important than others
        if ($this->followerRatio() > 3) {
            $rateFollower = $this->followerRatio();
            if ($this->followerRatio > 30) {
                $rateFollower = 30;
            }
            if ($this->followers <= 150) {
                $rateFollower = 1;
            } elseif ($this->followers >= 500) {
                $rateFollower += 0.3;
            }

            if ($this->mediaCount >= 200) {
                $rateFollower += 0.3;
            }
            $rate += $rateFollower / 10;
        } else {
            $rate -= 1;
        }
        if ($this->isPrivate) {
            $rate -= 0.3;
        } else {
            $rate += 0.3;
        }
        if ($this->hasProfilePicture === true) {
            $rate += 0.3;
        } else {
            $rate -= 0.3;
        }

        return $rate;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setFollowingRequestedAt(): void
    {
        $this->followingRequestedAt = new \DateTime();
    }

    public function followingRating(): ?float
    {
        return $this->followingRating;
    }

    /**
     * @return float|null
     */
    public function followerRatio(): ?float
    {
        $this->setFollowerRatio();
        return $this->followerRatio;
    }
}