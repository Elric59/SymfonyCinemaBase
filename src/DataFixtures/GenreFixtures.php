<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
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
        $kinds=['Aventure','Action','Romance','Horreur'];
        foreach($kinds as $name){
            $kind = new Genre();
            $kind->setNomGenre($name);
            $manager->persist($kind);
            $this->addReference($kind->getNomGenre(), $kind);

        }
        $manager->flush();

    }

}
