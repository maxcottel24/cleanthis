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
            ->andWhere('o.status = :status') // Modifier ici pour vérifier le statut == 3
            ->setParameter('userId', $user->getId())
            ->setParameter('status', 3) // Supposons que 3 est le statut "en cours" ou "actif"
            ->getQuery()
            ->getSingleScalarResult();
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
