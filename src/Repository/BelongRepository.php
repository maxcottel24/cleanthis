<?php

namespace App\Repository;

use App\Entity\Belong;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Belong>
 *
 * @method Belong|null find($id, $lockMode = null, $lockVersion = null)
 * @method Belong|null findOneBy(array $criteria, array $orderBy = null)
 * @method Belong[]    findAll()
 * @method Belong[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BelongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Belong::class);
    }

    //    /**
    //     * @return Belong[] Returns an array of Belong objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Belong
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
