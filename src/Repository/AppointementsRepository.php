<?php

namespace App\Repository;

use App\Entity\Appointements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointements>
 *
 * @method Appointements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointements[]    findAll()
 * @method Appointements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointements::class);
    }

//    /**
//     * @return Appointements[] Returns an array of Appointements objects
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

//    public function findOneBySomeField($value): ?Appointements
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
