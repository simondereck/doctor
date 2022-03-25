<?php

namespace App\Repository;

use App\Entity\Single;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Single|null find($id, $lockMode = null, $lockVersion = null)
 * @method Single|null findOneBy(array $criteria, array $orderBy = null)
 * @method Single[]    findAll()
 * @method Single[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SingleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Single::class);
    }

    // /**
    //  * @return Single[] Returns an array of Single objects
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
    public function findOneBySomeField($value): ?Single
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function countSearch($params){
        $builder = $this->createQueryBuilder('s');
        $builder->select('count(s.id)');

        foreach($params as $key => $value){
            if ($value["like"])
                $builder->andWhere($builder->expr()->like('s.'.$value["key"],$builder->expr()->literal("%".$value["value"]."%")));
            else
                $builder->andWhere("s.".$value["key"]."=".$value["value"]);
        }

        return $builder->getQuery()->getSingleScalarResult();

    }

    public function paramsSearch($params,$limit,$offset,$order=null){
        $builder = $this->createQueryBuilder('s');

        foreach($params as $key => $value){
            if ($value["like"])
                $builder->andWhere($builder->expr()->like('s.'.$value["key"],$builder->expr()->literal("%".$value["value"]."%")));
            else
                $builder->andWhere("s.".$value["key"]."=".$value["value"]);
        }


        if ($limit)
            $builder->setMaxResults($limit);
        if ($offset)
            $builder->setFirstResult($offset);


        if ($order && $order==1){
            $builder->orderBy("s.pinyin","desc");
        }else if ($order && $order==2){
            $builder->orderBy("s.pinyin","asc");
        }


        return $builder->getQuery()->getResult();

    }
}
