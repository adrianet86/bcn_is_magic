<?php


namespace App\Posting\Domain\Model\Image;


use App\Posting\Domain\Model\Caption\Caption;
use Ramsey\Uuid\Uuid;

class Image
{
    const CAPTION_LABEL = '{CAPTION}';
    const CAPTION_CREDIT_LABEL = '{CREDIT}';
    const CAPTION_HASHTAGS_LABEL = '{HASTAGS}';
    const CAPTION_TEMPLATE = self::CAPTION_LABEL . '
.
.
.
Credit: ' . self::CAPTION_CREDIT_LABEL . '
.
.
.
' . self::CAPTION_HASHTAGS_LABEL;

    private string $id;
    private \DateTimeImmutable $createdAt;
    private string $providerId;
    private string $provider;
    private string $providerUrl;
    private ?string $path;
    private ?string $url;// TODO: delete ¿?
    private ?string $description;
    private int $likes;
    private int $numberOfComments;
    private string $author;
    private ?string $location;
    private int $views;
    private int $downloads;
    private array $tags;
    private ?\DateTimeImmutable $postedAt;
    private ?bool $isDiscarded;
    private ?string $caption;
    private ?float $rate;

    private function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->createdAt = new \DateTimeImmutable();
        $this->path = null;
        $this->url = null;
        $this->isDiscarded = null;
    }

    public static function create(
        string $providerId,
        string $provider,
        string $providerUrl,
        ?string $description,
        ?string $location,
        int $likes,
        int $numberOfComments,
        ?int $views,
        ?int $downloads,
        string $author,
        array $tags
    ): self
    {
        $self = new self();
        $self->providerId = $providerId;
        $self->provider = $provider;
        $self->providerUrl = $providerUrl;
        $self->description = $description;
        $self->location = $location;
        $self->likes = $likes;
        $self->numberOfComments = $numberOfComments;
        $self->views = $views;
        $self->downloads = $downloads;
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

    public function description(): ?string
    {
        return $this->description;
    }

    public function likes(): int
    {
        return $this->likes;
    }

    public function numberOfComments(): int
    {
        return $this->numberOfComments;
    }

    public function tags(): array
    {
        return $this->tags;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function views(): int
    {
        return $this->views;
    }

    public function downloads(): int
    {
        return $this->downloads;
    }

    public function location(): ?string
    {
        return $this->location;
    }

    public function postedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function isDiscarded(): ?bool
    {
        return $this->isDiscarded;
    }

    public function caption(): ?string
    {
        return $this->caption;
    }

    public function rate(): ?float
    {
        return $this->rate;
    }

    public function setIsDiscarded(bool $isDiscarded): void
    {
        $this->isDiscarded = $isDiscarded;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    /**
     * @param Caption $caption
     * @param array Hashtag $hashTags
     */
    public function generateCaption(Caption $caption, array $tags): void
    {
        $hashTagsString = '';
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $hashTagsString .= '#' . $tag . ' ';
            }
        }
        $captionString = str_replace(self::CAPTION_LABEL, $caption->text(), self::CAPTION_TEMPLATE);
        $captionString = str_replace(self::CAPTION_CREDIT_LABEL, $this->author, $captionString);
        $this->caption = str_replace(self::CAPTION_HASHTAGS_LABEL, $hashTagsString, $captionString);

        return;
    }
}