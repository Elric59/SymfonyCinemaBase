<?php

namespace App\Repository;

use App\Entity\CommentaireEpisode;
use App\Entity\CommentaireSaison;
use App\Entity\Episode;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireSaison|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireSaison|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireSaison[]    findAll()
 * @method CommentaireSaison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireSaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireSaison::class);
    }

    /*
     * On récupère tous commentaires de l'utilisateur sur les saison
     */
    public function findCommentSaisonByUser(Utilisateur $user)
    {
        return $this->createQueryBuilder('c')

            ->where('c.User = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
