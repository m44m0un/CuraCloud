<?php

namespace App\Repository;

use App\Entity\AssurancePolicy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssurancePolicy>
 *
 * @method AssurancePolicy|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssurancePolicy|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssurancePolicy[]    findAll()
 * @method AssurancePolicy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssurancePolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssurancePolicy::class);
    }

//    /**
//     * @return AssurancePolicy[] Returns an array of AssurancePolicy objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssurancePolicy
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
