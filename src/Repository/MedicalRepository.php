<?php

namespace App\Repository;

use App\Entity\Medical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medical|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medical|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medical[]    findAll()
 * @method Medical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medical::class);
    }

    // /**
    //  * @return Medical[] Returns an array of Medical objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Medical
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
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

        return $builder->getQuery()->getArrayResult();

    }


    public function getOneById($id){
        $builder = $this->createQueryBuilder('s');
        $builder->where("s.id=".$id);
        return $builder->getQuery()->getArrayResult();
    }

}
