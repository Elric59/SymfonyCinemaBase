<?php

namespace App\Entity;

use App\Repository\CommentaireSaisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireSaisonRepository::class)
 */
class CommentaireSaison
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Saison;



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
    public function getSaison()
    {
        return $this->Saison;
    }

    /**
     * @param mixed $Saison
     */
    public function setSaison($Saison): void
    {
        $this->Saison = $Saison;
    }




}
