<?php

namespace App\Repository;

use App\Entity\PortFolio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PortFolio|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortFolio|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortFolio[]    findAll()
 * @method PortFolio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortFolioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortFolio::class);
    }

    // /**
    //  * @return PortFolio[] Returns an array of PortFolio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PortFolio
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
