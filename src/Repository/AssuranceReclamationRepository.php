<?php

namespace App\Repository;

use App\Entity\AssuranceReclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssuranceReclamation>
 *
 * @method AssuranceReclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssuranceReclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssuranceReclamation[]    findAll()
 * @method AssuranceReclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssuranceReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssuranceReclamation::class);
    }

//    /**
//     * @return AssuranceReclamation[] Returns an array of AssuranceReclamation objects
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

//    public function findOneBySomeField($value): ?AssuranceReclamation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
