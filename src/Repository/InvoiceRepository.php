<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoice>
 *
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }


    public function findMonthlyRevenue()
    {
        $conn = $this->getEntityManager()->getConnection();
        $currentYear = date('Y');
        $currentMonth = date('n');
        $currentQuarter = ceil($currentMonth / 3);
        
        $sql = '
            SELECT YEAR(closing_at) AS year, MONTH(closing_at) AS month, SUM(amount) AS monthly_revenue
            FROM invoice
            WHERE YEAR(closing_at) = :year AND QUARTER(closing_at) = :quarter
            GROUP BY year, month
        ';
        $stmt = $conn->executeQuery($sql, [
            'year' => $currentYear,
            'quarter' => $currentQuarter,
        ]);
    
        return $stmt->fetchAllAssociative();
    }


    
public function findQuarterlyRevenue()
{
    $conn = $this->getEntityManager()->getConnection();
    $currentYear = date('Y'); 
    $sql = '
        SELECT YEAR(closing_at) AS year, QUARTER(closing_at) AS quarter, SUM(amount) AS quarterly_revenue
        FROM invoice
        WHERE YEAR(closing_at) = :currentYear
        GROUP BY year, quarter
    ';
    $stmt = $conn->executeQuery($sql, ['currentYear' => $currentYear]);

    return $stmt->fetchAllAssociative();


    public function findOperationByInvoice(Invoice $invoice)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('o')
            ->from('App\Entity\Operation', 'o')
            ->join('App\Entity\Belong', 'b', 'WITH', 'o.id = b.operation')
            ->where('b.invoice = :invoice')
            ->setParameter('invoice', $invoice);

        return $qb->getQuery()->getOneOrNullResult();
    }

    //    /**
    //     * @return Invoice[] Returns an array of Invoice objects
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

    //    public function findOneBySomeField($value): ?Invoice
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}

public function findAnnualRevenue()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = '
        SELECT YEAR(closing_at) AS year, SUM(amount) AS annual_revenue
        FROM invoice
        GROUP BY year
    ';
    $stmt = $conn->executeQuery($sql);

    return $stmt->fetchAllAssociative();
}
}

