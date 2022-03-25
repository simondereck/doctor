<?php

namespace App\Repository;

use App\Entity\Law;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Law|null find($id, $lockMode = null, $lockVersion = null)
 * @method Law|null findOneBy(array $criteria, array $orderBy = null)
 * @method Law[]    findAll()
 * @method Law[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LawRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Law::class);
    }

    // /**
    //  * @return Law[] Returns an array of Law objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Law
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
