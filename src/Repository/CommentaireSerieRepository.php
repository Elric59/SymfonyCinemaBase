<?php

namespace App\Repository;

use App\Entity\CommentaireEpisode;
use App\Entity\CommentaireSerie;
use App\Entity\Episode;
use App\Entity\Serie;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireSerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireSerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireSerie[]    findAll()
 * @method CommentaireSerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireSerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireSerie::class);
    }

    /*
     * On récupère tous commentaires de l'utilisateur sur les serie
     */

    public function findCommentSerieByUser(Utilisateur $user)
    {
        return $this->createQueryBuilder('c')

            ->where('c.User = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

}
