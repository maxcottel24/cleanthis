<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\Operation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Operation>
 *
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function findOperationsByUser($user)
    {
        return $this->createQueryBuilder('o')
            ->join('o.meeting', 'm')
            ->join('m.users', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }


    public function countActiveOperationsByUser(Users $user)
{
    return $this->createQueryBuilder('o')
        ->select('count(o.id)')
        ->join('o.meeting', 'm')
        ->join('m.users', 'u')
        ->where('u.id = :userId')
        ->andWhere('o.status != :status') // Modification ici pour corriger la syntaxe
        ->setParameter('userId', $user->getId())
        ->setParameter('status', 5) // Supprimez le != ici et placez-le dans le andWhere()
        ->getQuery()
        ->getSingleScalarResult();
}


public function countTasksByOperationType()
{
    return $this->createQueryBuilder('o') 
        ->select('t.label, COUNT(o.id) AS task_count')
        ->join('o.typeOperation', 't')
        ->groupBy('t.id')
        ->orderBy('task_count', 'DESC')
        ->getQuery()
        ->getResult();
}


public function calculateTotalRevenueByOperationType()
{
    return $this->createQueryBuilder('o') 
        ->select('t.label, SUM(o.price) AS total_revenue')
        ->join('o.typeOperation', 't') 
        ->groupBy('t.id')
        ->orderBy('total_revenue', 'DESC')
        ->getQuery()
        ->getResult();
}

public function findCostPerUnit()
{
    $qb = $this->createQueryBuilder('o');

    $qb->select('o.id, (o.price * COALESCE(o.discount, 1)) / o.floor_space  AS costPerUnit')
        ->where($qb->expr()->gt('o.floor_space', 0)); 

    return $qb->getQuery()->getResult();
}



    public function findByUser($userId)
    {
        return $this->createQueryBuilder('o')
            ->join('o.user', 'u') // Assurez-vous que 'user' est le bon nom de la relation dans votre entité Operation
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Operation[] Returns an array of Operation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Operation
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
