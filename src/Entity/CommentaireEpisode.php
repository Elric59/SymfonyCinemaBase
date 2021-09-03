<?php

namespace App\Entity;

use App\Repository\CommentaireEpisodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireEpisodeRepository::class)
 */
class CommentaireEpisode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     *
     */
    private $Descriptif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Episode")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Episode;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescriptif()
    {
        return $this->Descriptif;
    }

    /**
     * @param mixed $Descriptif
     */
    public function setDescriptif($Descriptif): void
    {
        $this->Descriptif = $Descriptif;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser(?Utilisateur $User): void
    {
        $this->User = $User;
    }

    /**
     * @return mixed
     */
    public function getEpisode()
    {
        return $this->Episode;
    }

    /**
     * @param mixed $Episode
     */
    public function setEpisode(?Episode $Episode): void
    {
        $this->Episode = $Episode;
    }





}
