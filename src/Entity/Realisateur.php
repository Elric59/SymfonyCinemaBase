<?php

namespace App\Entity;

use App\Repository\RealisateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealisateurRepository::class)
 */
class Realisateur
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
    private $nomRealisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNomRealisateur()
    {
        return $this->nomRealisateur;
    }

    /**
     * @param mixed $nomRealisateur
     */
    public function setNomRealisateur($nomRealisateur): void
    {
        $this->nomRealisateur = $nomRealisateur;
    }


}
