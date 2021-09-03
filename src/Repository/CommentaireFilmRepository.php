<?php

namespace App\Repository;

use App\Entity\CommentaireEpisode;
use App\Entity\CommentaireFilm;
use App\Entity\Episode;
use App\Entity\Film;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireFilm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireFilm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireFilm[]    findAll()
 * @method CommentaireFilm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireFilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireFilm::class);
    }

    /*
     * On récupère tous commentaires de l'utilisateur sur les films
     */
    public function findCommentFilmByUser(Utilisateur $user)
    {
        return $this->createQueryBuilder('c')

            ->where('c.User = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
