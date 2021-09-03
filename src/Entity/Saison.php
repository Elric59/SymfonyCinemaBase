<?php

namespace App\Entity;

use App\Repository\SaisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaisonRepository::class)
 */
class Saison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomSaison;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionSaison;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $Serie;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getNomSaison()
    {
        return $this->nomSaison;
    }

    /**
     * @param mixed $nomSaison
     */
    public function setNomSaison($nomSaison): void
    {
        $this->nomSaison = $nomSaison;
    }

    /**
     * @return mixed
     */
    public function getDescriptionSaison()
    {
        return $this->descriptionSaison;
    }

    /**
     * @param mixed $descriptionSaison
     */
    public function setDescriptionSaison($descriptionSaison): void
    {
        $this->descriptionSaison = $descriptionSaison;
    }

    /**
     * @return mixed
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * @param mixed $dateSortie
     */
    public function setDateSortie($dateSortie): void
    {
        $this->dateSortie = $dateSortie;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->Serie;
    }

    /**
     * @param mixed $Serie
     */
    public function setSerie($Serie): void
    {
        $this->Serie = $Serie;
    }




}
