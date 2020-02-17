<?php

namespace App\Repository;

use App\Entity\Kids;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Kids|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kids|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kids[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KidsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kids::class);
    }

    public function findAll(){
      $queryBuilder = $this->createQueryBuilder('k')
        ->orderBy('k.user','DESC')
        ->getQuery();

      return $queryBuilder->getResult();
    }

    // /**
    //  * @return Kids[] Returns an array of Kids objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kids
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
