<?php

namespace App\Repository;

use App\Entity\Invoices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoices>
 *
 * @method Invoices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoices[]    findAll()
 * @method Invoices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoices::class);
    }

//    /**
//     * @return Invoices[] Returns an array of Invoices objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Invoices
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
