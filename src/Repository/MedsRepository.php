<?php

namespace App\Repository;

use App\Entity\Meds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meds>
 *
 * @method Meds|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meds|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meds[]    findAll()
 * @method Meds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meds::class);
    }

//    /**
//     * @return Meds[] Returns an array of Meds objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Meds
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
