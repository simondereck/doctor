<?php

namespace App\Repository;

use App\Entity\Store;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Store|null find($id, $lockMode = null, $lockVersion = null)
 * @method Store|null findOneBy(array $criteria, array $orderBy = null)
 * @method Store[]    findAll()
 * @method Store[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }

    // /**
    //  * @return Store[] Returns an array of Store objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Store
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findResultsByIdsAndDate($tid,$type){
        return $this->createQueryBuilder('s')
            ->andWhere('s.tid = :val')
            ->andWhere('s.type = :type')
            ->setParameter('type',$type)
            ->setParameter('val',$tid)
            ->orderBy('s.id', 'desc')
            ->setMaxResults(6)
            ->getQuery()
            ->getArrayResult();
    }


    public function findAllStoreByIdsAndTypes($tid,$type){
        return $this->createQueryBuilder('s')
            ->andWhere('s.tid = :val')
            ->andWhere('s.type = :type')
            ->setParameter('type',$type)
            ->setParameter('val',$tid)
            ->orderBy('s.id', 'desc')
            ->getQuery()
            ->getArrayResult();
    }
}
