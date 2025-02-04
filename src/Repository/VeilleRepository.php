<?php

namespace App\Repository;

use App\Entity\Veille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Veille>
 */
class VeilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veille::class);
    }


    public function findFirstByIdAsc(): ?Veille
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(1)  // Limite à un seul résultat
            ->getQuery()
            ->getOneOrNullResult();  // Retourne null si aucun résultat
    }

    //    /**
    //     * @return Veille[] Returns an array of Veille objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Veille
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
