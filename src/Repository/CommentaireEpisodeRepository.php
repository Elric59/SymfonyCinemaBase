<?php

namespace App\Repository;

use App\Entity\CommentaireEpisode;
use App\Entity\Episode;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireEpisode|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireEpisode|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireEpisode[]    findAll()
 * @method CommentaireEpisode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireEpisodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireEpisode::class);
    }

    /*
     * On récupère tous commentaires de l'utilisateur sur les épisodes
     */
    public function findCommentEpisodeByUser(Utilisateur $user)
    {
        return $this->createQueryBuilder('c')

            ->where('c.User = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

}
