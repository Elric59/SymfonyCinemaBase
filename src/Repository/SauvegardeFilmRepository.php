<?php

namespace App\Repository;

use App\Entity\Film;
use App\Entity\SauvegardeFilm;
use App\Entity\SauvegardeSerie;
use App\Entity\Serie;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SauvegardeFilm|null find($id, $lockMode = null, $lockVersion = null)
 * @method SauvegardeFilm|null findOneBy(array $criteria, array $orderBy = null)
 * @method SauvegardeFilm[]    findAll()
 * @method SauvegardeFilm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SauvegardeFilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SauvegardeFilm::class);
    }

    public function getSaveByUser(Utilisateur $user,Film $film)
    {
        return $this->createQueryBuilder('save')
            ->select('save.id')
            ->where('save.utilisateur = :user')
            ->andWhere('save.film = :film')
            ->setParameter('user', $user)
            ->setParameter('film', $film)
            ->getQuery()
            ->getResult();
    }

}
