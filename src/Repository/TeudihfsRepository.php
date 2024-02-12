<?php

namespace App\Repository;

use App\Entity\Teudihfs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Teudihfs>
 *
 * @method Teudihfs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teudihfs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teudihfs[]    findAll()
 * @method Teudihfs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeudihfsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teudihfs::class);
    }

//    /**
//     * @return Teudihfs[] Returns an array of Teudihfs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Teudihfs
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
