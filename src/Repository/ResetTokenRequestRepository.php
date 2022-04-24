<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ResetTokenRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResetTokenRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResetTokenRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResetTokenRequest[]    findAll()
 * @method ResetTokenRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResetTokenRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetTokenRequest::class);
    }

    // /**
    //  * @return ResetTokenRequest[] Returns an array of ResetTokenRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResetTokenRequest
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
