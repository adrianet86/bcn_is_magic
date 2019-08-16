<?php


namespace App\Posting\Domain\Model\Image;


interface ImageRepository
{
    /**
     * @param Image $image
     */
    public function save(Image $image): void;

    /**
     * @param string $provider
     * @param string $providerId
     * @return Image
     * @throws ImageNotFoundException
     */
    public function byProvider(string $provider, string $providerId): Image;

    public function unprocessed(int $offset = 1, $limit = 1000): array;

    /**
     * @param string $imageId
     * @return Image
     */
    public function byId(string $imageId): Image;

    /**
     * @param int $offset
     * @param int $limit
     * @return array Image
     */
    public function notPosted(int $offset = 1, int $limit = 500): array;

    /**
     * @param int $offset
     * @param int $limit
     * @return Image
     * @throws ImageNotFoundException
     */
    public function notPostedOrFail(int $offset = 1, int $limit = 500): Image;

    public function totalByProvider(string $provider): int;
}