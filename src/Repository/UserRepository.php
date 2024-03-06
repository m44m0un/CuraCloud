<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
* @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function showUsersSortedByEmail(User $currentUser)
    {
        return $this->createQueryBuilder('u')
        ->select('u.id', 'u.email', 'u.roles', 'u.phoneNumber', 'u.inscriptionDate', 'u.isbanned')
        ->where('u != :currentUser')
        ->setParameter('currentUser', $currentUser)
        ->orderBy('u.email', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function findAllUsersWithSpecificFieldsExceptCurrentUserAndRolesStatus(User $currentUser, ?string $role = null, ?string $status = null)
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u.id', 'u.email', 'u.roles', 'u.phoneNumber', 'u.inscriptionDate', 'u.isbanned')
            ->andWhere('u != :currentUser')
            ->setParameter('currentUser', $currentUser);
            
            if ($role !== null) {
                $roleConditions = [];
        
                // Map role query values to corresponding role conditions
                $roleMappings = [
                    'Patient' => 'ROLE_PATIENT',
                    'Doctor' => 'ROLE_DOCTOR',
                    'Pharmacy' => 'ROLE_PHARMACY',
                    'Radiology' => 'ROLE_RADIOLOGY',
                    'Laboratory' => 'ROLE_LAB',
                    // Add more mappings as needed
                ];
        
                if (isset($roleMappings[$role])) {
                    $roleConditions[] = $queryBuilder->expr()->like('u.roles', $queryBuilder->expr()->literal('%' . $roleMappings[$role] . '%'));
                }
        
                // Combine role conditions using OR operator
                $queryBuilder->andWhere($queryBuilder->expr()->orX(...$roleConditions));
            }
        
            if ($status === "Active" || $status === "Banned") {
                $isBanned = ($status === "Banned") ? true : false;
                $queryBuilder->andWhere('u.isbanned = :banned')
                    ->setParameter('banned', $isBanned);
            }

        $queryBuilder->orderBy('u.inscriptionDate', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    public function countBannedUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.isbanned)')
            ->Where('u.isbanned = :ban')
            ->setParameter('ban', '1')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getPercentageOfUsersCreatedInCurrentMonth()
    {
        $currentDate = new \DateTime();
        $currentMonth = $currentDate->format('n'); // Get the current month (1-12)
        $currentYear = $currentDate->format('Y');  // Get the current year

        $startOfMonth = new \DateTime(sprintf('%d-%02d-01 00:00:00', $currentYear, $currentMonth));
        $endOfMonth = clone $startOfMonth;
        $endOfMonth->modify('last day of this month')->setTime(23, 59, 59);

        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id) as userCount')
            ->andWhere($qb->expr()->between('u.inscriptionDate', ':startOfMonth', ':endOfMonth'))
            ->setParameter('startOfMonth', $startOfMonth)
            ->setParameter('endOfMonth', $endOfMonth);

        $totalUsers = $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $userCount = $qb->getQuery()->getSingleScalarResult();

        // Avoid division by zero
        $percentage = ($totalUsers > 0) ? round(($userCount / $totalUsers) * 100) : 0;

        return $percentage;
    }


//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
