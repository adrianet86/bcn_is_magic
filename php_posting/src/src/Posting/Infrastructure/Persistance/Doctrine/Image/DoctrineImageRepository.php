<?php


namespace App\Posting\Infrastructure\Persistance\Doctrine\Image;


use App\Posting\Domain\Model\Image\Image;
use App\Posting\Domain\Model\Image\ImageNotFoundException;
use App\Posting\Domain\Model\Image\ImageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineImageRepository implements ImageRepository
{
    private EntityManager $entityManager;

    private EntityRepository $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Image::class);
    }

    public function save(Image $image): void
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush($image);
    }

    /**
     * @param string $provider
     * @param string $providerId
     * @return Image
     * @throws ImageNotFoundException
     */
    public function byProvider(string $provider, string $providerId): Image
    {
        $entity = $this->repository->findOneBy([
            'provider' => $provider,
            'providerId' => $providerId
        ]);

        if ($entity instanceof Image) {
            return $entity;
        }

        throw new ImageNotFoundException('IMAGE NOT FOUND FOR PROVIDER: ' . $provider . ' - ' . $providerId);
    }

    public function unprocessed(int $offset = 1, $limit = 500): array
    {
        return $this->repository->findBy([
            'isDiscarded' => null
        ],
            null,
            $limit,
            $offset
        );
    }
}