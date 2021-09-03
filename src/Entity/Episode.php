<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EpisodeRepository::class)
 */
class Episode
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
    private $nomEpisode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionEpisode;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $Saison;



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
    public function getNomEpisode()
    {
        return $this->nomEpisode;
    }

    /**
     * @param mixed $nomEpisode
     */
    public function setNomEpisode($nomEpisode): void
    {
        $this->nomEpisode = $nomEpisode;
    }

    /**
     * @return mixed
     */
    public function getDescriptionEpisode()
    {
        return $this->descriptionEpisode;
    }

    /**
     * @param mixed $descriptionEpisode
     */
    public function setDescriptionEpisode($descriptionEpisode): void
    {
        $this->descriptionEpisode = $descriptionEpisode;
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
