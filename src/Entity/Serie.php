<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie
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
    private $nomSerie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionSerie;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSortie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre")
     */
    private $Genre ;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Acteur")
     */
    private $Acteur;



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
    public function getNomSerie()
    {
        return $this->nomSerie;
    }

    /**
     * @param mixed $nomSerie
     */
    public function setNomSerie($nomSerie): void
    {
        $this->nomSerie = $nomSerie;
    }

    /**
     * @return mixed
     */
    public function getDescriptionSerie()
    {
        return $this->descriptionSerie;
    }

    /**
     * @param mixed $descriptionSerie
     */
    public function setDescriptionSerie($descriptionSerie): void
    {
        $this->descriptionSerie = $descriptionSerie;
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
    public function getGenre()
    {
        return $this->Genre;
    }

    /**
     * @param mixed $Genre
     */
    public function setGenre(Genre $Genre): void
    {
        $this->Genre = $Genre;
    }

    /**
     * @return mixed
     */
    public function getActeur()
    {
        return $this->Acteur;
    }

    /**
     * @param mixed $Acteur
     */
    public function setActeur(Acteur $Acteur): void
    {
        $this->Acteur = $Acteur;
    }


    public function addGenre(Genre $genre)
    {
        $this->Genre[] = $genre;

        return $this;
    }

    public function addActeur(Acteur $acteur)
    {
        $this->Acteur[] = $acteur;

        return $this;
    }






}
