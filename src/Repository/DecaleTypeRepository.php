<?php

namespace App\Repository;

use App\Entity\DecaleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DecaleType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DecaleType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DecaleType[]    findAll()
 * @method DecaleType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecaleTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DecaleType::class);
    }

    // /**
    //  * @return DecaleType[] Returns an array of DecaleType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DecaleType
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
