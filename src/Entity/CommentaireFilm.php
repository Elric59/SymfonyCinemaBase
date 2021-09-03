<?php

namespace App\Entity;

use App\Repository\CommentaireFilmRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireFilmRepository::class)
 */
class CommentaireFilm
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Film")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Film;



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
    public function setUser($User): void
    {
        $this->User = $User;
    }

    /**
     * @return mixed
     */
    public function getFilm()
    {
        return $this->Film;
    }

    /**
     * @param mixed $Film
     */
    public function setFilm($Film): void
    {
        $this->Film = $Film;
    }


}
