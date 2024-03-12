<?php

namespace App\Repository;

use App\Entity\Appointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Appointment>
 *
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

//    /**
//     * @return Appointment[] Returns an array of Appointment objects
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

//    public function findOneBySomeField($value): ?Appointment
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// public function findByDate($date)
// {
//     return $this->createQueryBuilder('a')
//         ->andWhere('a.date = :date')
//         ->setParameter('date', $date)
//         ->getQuery()
//         ->getResult();
// }
// public function sortByTime()
// {
//     return $this->createQueryBuilder('a')
//         ->orderBy('a.time', 'ASC')
//         ->getQuery()
//         ->getResult();
// }
// public function findByStatus($status)
// {
//     return $this->createQueryBuilder('a')
//         ->andWhere('a.status = :status')
//         ->setParameter('status', $status)
//         ->getQuery()
//         ->getResult();
// }
   /**
     * Search for appointments based on description or status.
     * 
     * @param string|null $description The description to search for.
     * @param string|null $status The status to search for.
     * @return Appointment[] Returns an array of Appointment objects.
     */
   
        public function findOverlappingAppointments(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
        {
            return $this->createQueryBuilder('a')
                ->where('a.startDate < :endDate AND a.endDate > :startDate')
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate)
                ->getQuery()
                ->getResult();
        }
   
        public function findByDoctorId($doctorId)
        {
            return $this->createQueryBuilder('a') // 'a' is an alias for Appointment
                ->andWhere('a.id_doctor = :doctorId')
                ->setParameter('doctorId', $doctorId)
                ->getQuery()
                ->getResult()
            ;
        }
        public function findAverageRatingByDoctor()
        {
            return $this->createQueryBuilder('a')
                ->select('identity(a.id_doctor) as doctorId, AVG(a.Rating) as averageRating')
                ->groupBy('a.id_doctor')
                ->getQuery()
                ->getResult();
        }
}
