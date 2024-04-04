<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @extends ServiceEntityRepository<Invoice>
 * @author Nacim <nacim.ouldrabah@gmail.com>
 * @author Efflam <cefflam@gmail.com>
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
}

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



    /**
     * @return Invoice[] Returns an array of Invoice objects linked to the given user
     */
    public function findByUser($userId)
    {
        return $this->createQueryBuilder('i')
            ->join('App\Entity\Belong', 'b', 'WITH', 'b.invoice = i.id')
            ->join('b.operation', 'o')
            ->join('o.meeting', 'm')
            ->join('m.users', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }




    // public function findInvoicesByOperatorUser($userId)
    // {
    //     $qb = $this->getEntityManager()->createQueryBuilder();

    //     $qb->select('i')
    //         ->from('App\Entity\Invoice', 'i')
    //         ->join('App\Entity\Belong', 'b', 'WITH', 'b.invoice = i')
    //         ->join('b.operation', 'o')
    //         ->join('o.meeting', 'm')
    //         ->join('m.users', 'u')
    //         ->where('u.id = :userId')
    //         ->andWhere('u.job_title = :job_title')
    //         ->setParameter('userId', $userId)
    //         ->setParameter('job_title', 'Opérateur');

    //     return $qb->getQuery()->getResult();
    // }


    public function findInvoicesByOperatorUser($userId)
{
    $qb = $this->createQueryBuilder('i')
        ->join('App\Entity\Belong', 'b', 'WITH', 'b.invoice = i')
        ->join('b.operation', 'o')
        ->join('o.meeting', 'm')
        ->join('m.users', 'u')
        ->where('u.id = :userId')
        ->andWhere('u.job_title = :jobTitle')
        ->andWhere('i.status = :status')
        ->setParameter('userId', $userId) // Notez l'utilisation de setParameter au lieu de setParameters
        ->setParameter('jobTitle', 'Null')
        ->setParameter('status', 1);

    $query = $qb->getQuery();

    // Pour obtenir les résultats
    return $query->getResult();
}

public function findByUsers(int $userId): array
{
    return $this->createQueryBuilder('i')
        ->join('App\Entity\Belong', 'b', 'WITH', 'b.invoice = i')
        ->join('b.operation', 'o')
        ->join('o.meeting', 'm')
        ->join('m.user', 'u')
        ->where('u.id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
}

// Dans InvoiceRepository.php

public function findInvoicesByUser($userId)
{
    return $this->createQueryBuilder('i')
        ->join('i.belongs', 'b')
        ->join('b.operation', 'o')
        ->join('o.meeting', 'm')
        ->join('m.users', 'u')
        ->where('u.id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
}



    public function findInvoicesByOperatorUserFinished($userId)
{
    $qb = $this->createQueryBuilder('i')
        ->join('App\Entity\Belong', 'b', 'WITH', 'b.invoice = i')
        ->join('b.operation', 'o')
        ->join('o.meeting', 'm')
        ->join('m.users', 'u')
        ->where('u.id = :userId')
        ->andWhere('u.job_title = :jobTitle')
        ->andWhere('i.status = :status')
        ->setParameter('userId', $userId) // Notez l'utilisation de setParameter au lieu de setParameters
        ->setParameter('jobTitle', 'Opérateur')
        ->setParameter('status', 2);

    $query = $qb->getQuery();

    // Pour obtenir les résultats
    return $query->getResult();
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
