<?php
// src/Repository/StreamRepository.php
namespace App\Repository;

use App\Entity\Stream;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StreamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stream::class);
    }

    /**
     * Find an active stream by user.
     *
     * @param string $userId
     *
     * @return Stream|null
     */
    public function findActiveStreamByUser(string $userId): ?Stream
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :userId')
            ->andWhere('s.isActive = true')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find all active streams.
     *
     * @return Stream[]
     */
    public function findAllActiveStreams(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.isActive = true')
            ->getQuery()
            ->getResult();
    }
}

