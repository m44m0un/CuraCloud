<?php

namespace App\Repository;

use App\Entity\Tezercge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tezercge>
 *
 * @method Tezercge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tezercge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tezercge[]    findAll()
 * @method Tezercge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TezercgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tezercge::class);
    }

//    /**
//     * @return Tezercge[] Returns an array of Tezercge objects
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

//    public function findOneBySomeField($value): ?Tezercge
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
