<?php

namespace App\Repository;

use App\Entity\FishingLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FishingLog>
 *
 * @method FishingLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method FishingLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method FishingLog[]    findAll()
 * @method FishingLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FishingLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FishingLog::class);
    }

//    /**
//     * @return FishingLog[] Returns an array of FishingLog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FishingLog
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
