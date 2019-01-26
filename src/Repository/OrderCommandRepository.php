<?php

namespace App\Repository;

use App\Entity\OrderCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OrderCommand|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderCommand|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderCommand[]    findAll()
 * @method OrderCommand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderCommandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderCommand::class);
    }

    // /**
    //  * @return OrderCommand[] Returns an array of OrderCommand objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderCommand
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
