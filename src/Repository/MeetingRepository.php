<?php

namespace App\Repository;

use App\Entity\Meeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meeting>
 *
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    // Dans App\Repository\MeetingRepository.php

    /**
     * @return Meeting[] Returns an array of Meeting objects
     */
    public function findByOperatorUser($userId)
    {
        return $this->createQueryBuilder('m')
        ->join('m.users', 'u')
        ->andWhere('u.id = :userId')
        ->andWhere('u.job_title = :jobTitle') // Assurez-vous que cela correspond au nom de la propriété dans l'entité.
        ->setParameter('userId', $userId)
        ->setParameter('jobTitle', 'Opérateur')
        ->getQuery()
        ->getResult()
    ;
    }



    public function findAll(): array
    {
        return $this->createQueryBuilder('p')
            // ->where('p.status = 1')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Meeting[] Returns an array of Meeting objects
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

    //    public function findOneBySomeField($value): ?Meeting
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
