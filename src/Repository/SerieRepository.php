<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    /*
     * On récupère les series
     */
    public function getSeries(){
        return $this->createQueryBuilder('serie')

            ->orderBy('serie.nomSerie','ASC');
    }

    public function getSeriesToPrint(){
        return $this->createQueryBuilder('serie')
            ->orderBy('serie.nomSerie','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
