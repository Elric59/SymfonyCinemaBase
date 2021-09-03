<?php

namespace App\Repository;

use App\Entity\Saison;
use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Saison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saison[]    findAll()
 * @method Saison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saison::class);
    }

    /*
     * On récupère le nom saisons disponible
     */

    public function getSaisons(){
        return $this->createQueryBuilder('saison')
            ->orderBy('saison.nomSaison','ASC');
    }

    /*
     * On récupère le nom saisons associé avec les séries
     */
    public function getSeriesWithSaisons(Serie $serie){
        return $this->createQueryBuilder('saison')
            ->innerJoin('saison.Serie','serie')
            ->where('saison.Serie = :serie')
            ->setParameter('serie',$serie)
            ->orderBy('serie.nomSerie')
            ->getQuery()
            ->getResult();
    }

}
