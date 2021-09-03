<?php

namespace App\Repository;

use App\Entity\SauvegardeSerie;
use App\Entity\Serie;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SauvegardeSerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SauvegardeSerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SauvegardeSerie[]    findAll()
 * @method SauvegardeSerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SauvegardeSerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SauvegardeSerie::class);
    }

    public function getSaveByUser(Utilisateur $user,Serie $serie)
    {
        return $this->createQueryBuilder('save')
            ->select('save.id')
            ->where('save.utilisateur = :user')
            ->andWhere('save.serie = :serie')
            ->setParameter('user', $user)
            ->setParameter('serie', $serie)
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return SauvegardeSerie[] Returns an array of SauvegardeSerie objects
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
    public function findOneBySomeField($value): ?SauvegardeSerie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
