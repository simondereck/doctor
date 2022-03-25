<?php

namespace App\Repository;

use App\Entity\Herb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Herb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Herb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Herb[]    findAll()
 * @method Herb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HerbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Herb::class);
    }

    // /**
    //  * @return Herb[] Returns an array of Herb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Herb
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
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


    public function searchByKeywords($keywords){
        $builder = $this->createQueryBuilder('s');

        $builder->where($builder->expr()->like('s.name',$builder->expr()->literal("%".$keywords."%")));
        $builder->orWhere($builder->expr()->like('s.pinyin',$builder->expr()->literal("%".$keywords."%")));
        $builder->orWhere($builder->expr()->like('s.latinName',$builder->expr()->literal("%".$keywords."%")));
        $builder->setMaxResults(10);
        return $builder->getQuery()->getArrayResult();

    }


    public function getMedicalsByIds($ids){
        $builder = $this->createQueryBuilder('s');
        $builder->where($builder->expr()->in('s.id', $ids));
        return $builder->getQuery()->getArrayResult();
    }
}
