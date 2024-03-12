<?php

namespace App\Repository;

use App\Entity\DiagnosticRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiagnosticRequest>
 *
 * @method DiagnosticRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiagnosticRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiagnosticRequest[]    findAll()
 * @method DiagnosticRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiagnosticRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiagnosticRequest::class);
    }

//    /**
//     * @return DiagnosticRequest[] Returns an array of DiagnosticRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DiagnosticRequest
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findAllSortedByCreationDate(): array
{
    return $this->createQueryBuilder('d')
        ->orderBy('d.creationDate', 'DESC')
        ->getQuery()
        ->getResult();
}

public function findAllOrderedByUserName(): array
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.id_patient', 'u')
            ->orderBy('u.firstName', 'ASC')
            ->addOrderBy('u.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getDistinctCategories(): array
{
    // Utilisez le QueryBuilder pour récupérer les catégories distinctes
    $queryBuilder = $this->createQueryBuilder('r');
    $queryBuilder->select('DISTINCT r.status');
    $result = $queryBuilder->getQuery()->getResult();

    return array_column($result, 'status');
}

public function countByCategory(string $category): int
{
    // Utilisez le QueryBuilder pour compter le nombre de réclamations pour une catégorie donnée
    $queryBuilder = $this->createQueryBuilder('r');
    $queryBuilder->select('COUNT(r.id)');
    $queryBuilder->where('r.status = :status');
    $queryBuilder->setParameter('status', $category);

    return (int)$queryBuilder->getQuery()->getSingleScalarResult();
}
public function countAll(): int
{
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery('SELECT COUNT(r.id) FROM App\Entity\DiagnosticRequest r');
    return (int) $query->getSingleScalarResult();
}
//Stat
public function countByRegion()
    {
        //$query = $this->createQueryBuilder('c')
        //->select('SUBSTRING(d.date, 1, 10) as date, COUNT(c) as count')
        //->groupBy('date')
        //;
        //return $query->getQuery()->getResult();
        $query = $this->getEntityManager()->createQuery("
           SELECT l.status as regionL, count(l) as countL FROM App\Entity\DiagnosticRequest l where l.status IS NOT NULL GROUP BY regionL 
       ");
        return $query->getResult();
    }

    public function getUserConnected(int $userId)
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u.analyseType', 'u.radioType', 'u.doctorNotes', 'u.status', 'u.creationDate')
            ->andWhere('u.id_patient = :userId')
            ->setParameter('userId', $userId);
    
        // Exécutez la requête et retournez le résultat
        return $queryBuilder->getQuery()->getResult();
    }

    public function search(array $criteria): array
{
    $queryBuilder = $this->createQueryBuilder('d');

    // Ajoutez vos conditions de recherche en fonction des critères passés

    // Exemple : recherche par type d'analyse
    if (isset($criteria['analyseType'])) {
        $queryBuilder
            ->andWhere('d.analyseType = :analyseType')
            ->setParameter('analyseType', $criteria['analyseType']);
    }

    // Ajoutez d'autres conditions de recherche selon vos besoins

    return $queryBuilder->getQuery()->getResult();
}

}
