<?php

namespace App\Entity;

use App\Repository\ActeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActeurRepository::class)
 */
class Acteur
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
     */
    private $NameActor;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNameActor()
    {
        return $this->NameActor;
    }

    /**
     * @param mixed $NameActor
     */
    public function setNameActor($NameActor): void
    {
        $this->NameActor = $NameActor;
    }




}
