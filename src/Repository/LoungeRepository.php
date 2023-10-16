<?php

namespace App\Repository;

use App\Entity\Lounge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lounge>
 *
 * @method Lounge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lounge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lounge[]    findAll()
 * @method Lounge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoungeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lounge::class);
    }

//    /**
//     * @return Lounge[] Returns an array of Lounge objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Lounge
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
