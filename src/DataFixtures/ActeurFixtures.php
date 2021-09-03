<?php

namespace App\DataFixtures;

use App\Entity\Acteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActeurFixtures extends Fixture
{
    private $dataDirectory;

    public function __construct($dataDirectory)
    {
        $this->dataDirectory = $dataDirectory;
    }
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $acteurs=["Billy","Philibert","Gilbert"];
        foreach($acteurs as $name){
            $acteur = new Acteur();
            $acteur->setNameActor($name);
            $manager->persist($acteur);
            $this->addReference($acteur->getNameActor(), $acteur);

        }
        $manager->flush();
    }


    }






