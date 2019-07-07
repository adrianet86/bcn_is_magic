<?php


namespace App\Posting\Domain\Model\Image;


use Ramsey\Uuid\Uuid;

class Image
{
    private string $id;
    private \DateTimeImmutable $createdAt;
    private string $providerId;
    private string $provider;
    private string $providerUrl;
    private ?string $path;
    private ?string $url;

    // METADATA
    private string $description;
    private int $likes;
    private int $numberComments;
    private string $author;
    private array $tags;

    private function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->createdAt = new \DateTimeImmutable();
        $this->path = null;
        $this->url = null;
    }

    public static function create(
        string $providerId,
        string $provider,
        string $providerUrl,
        string $description,
        int $likes,
        int $numberComments,
        string $author,
        array $tags
    ): self
    {
        $self = new self();
        $self->providerId = $providerId;
        $self->provider = $provider;
        $self->providerUrl = $providerUrl;
        $self->description = $description;
        $self->likes = $likes;
        $self->numberComments = $numberComments;
        $self->author = $author;
        $self->tags = $tags;

        return $self;
    }

    public function providerUrl(): string
    {
        return $this->providerUrl;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function providerId(): string
    {
        return $this->providerId;
    }

    public function provider(): string
    {
        return $this->provider;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function likes(): int
    {
        return $this->likes;
    }

    public function numberComments(): int
    {
        return $this->numberComments;
    }

    public function tags(): array
    {
        return $this->tags;
    }

    public function author(): string
    {
        return $this->author;
    }
}