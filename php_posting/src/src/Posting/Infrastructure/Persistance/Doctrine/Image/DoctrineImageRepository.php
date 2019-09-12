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

    /**
     * @param string $imageId
     * @return Image
     * @throws ImageNotFoundException
     */
    public function byId(string $imageId): Image
    {
        $entity = $this->repository->find($imageId);
        if ($entity instanceof Image) {
            return $entity;
        }

        throw new ImageNotFoundException('IMAGE NOT FOUND FOR ID: ' . $imageId);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array Image
     */
    public function notPosted(int $offset = 1, int $limit = 500): array
    {
        $qb = $this->repository->createQueryBuilder('i');

        $qb->select()
            ->where('i.postedAt IS NULL')
            ->andWhere('i.isDiscarded != false')
            ->addOrderBy('i.likes', 'DESC')
            ->addOrderBy('i.views',  'DESC')
            ->addOrderBy('i.downloads',  'DESC');

        return $qb->getQuery()->execute();
    }

    public function notPostedOrFail(int $offset = 1, int $limit = 500): Image
    {
        $images = $this->notPosted(1, 1);
        if (empty($images)) {
            throw new ImageNotFoundException('NO AVAILABLE IMAGES NOT POSTED');
        }

        $image = $images[0];
        if (!$image instanceof Image) {
            throw new ImageNotFoundException('NO AVAILABLE IMAGES NOT POSTED');
        }

        return $image;
    }

    public function totalByProvider(string $provider): int
    {
        $qb = $this->repository->createQueryBuilder('i');
        $qb->select('count(i.id)')
            ->where('i.provider = :provider')
            ->setParameter('provider', $provider);

        return $qb->getQuery()->getSingleScalarResult();
    }
}