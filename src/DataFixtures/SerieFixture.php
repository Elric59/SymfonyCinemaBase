<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Saison;
use App\Entity\Serie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SerieFixture extends Fixture implements DependentFixtureInterface
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
        $datas = array(
            array("Les Expert Miami",
                "Une équipe de chercheurs en médecine légale de Miami, en Floride, utilise des technologies modernes, des méthodes de pointe, et le bon vieux travail de flic afin de résoudre les crimes les plus divers",
                "2012-04-12",
                ['Billy', 'Philibert', 'Gilbert'],
                ['Aventure', 'Action'],
                "611baad6ac0ebWarframe0000.jpg",
                array("Les Premieres Enquetes !",
                    "Premiere enquete des expert",
                    "2012-04-12",
                    "1404848.jpg",
                    array(
                        "sang et glace",
                        "premier meutre pour nos expert , le tueur de glace ...",
                        "2012-04-12",
                        "37027234.jpg"
                    )
                )
            ),

            array("La famille pirate",
                "Le capitaine Victor Mc Bernik, pirate pas très futé et un peu maladroit doit, doit s'occuper de sa famille en plus de piller les galions, rechercher les trésors et affronter ses voisins, sa belle-mère et les autres pirates.",
                "1999-09-04",
                ['Billy', 'Philibert', 'Gilbert'],
                ['Aventure', 'Action'],
                "9782205068894-couv.jpg",
                array(
                    "La découverte de la famille",
                    "Nous découvrons la famille Mc Bernik dans cette saison ! ",
                    "1999-09-04",
                    "1332487.jpg",
                    array(
                        "Une famille pas comme les autres",
                        "découverte de la famille dans cette épisode",
                        "1999-09-04",
                        "25736260.jpg"
                    )
                )
            ),

        );
        foreach ($datas as $data) {
            $serie = new Serie();
            $serie->setNomSerie($data[0]);
            $serie->setDescriptionSerie($data[1]);
            $serie->setDateSortie(DateTime::createFromFormat('Y-m-j', $data[2]));
            foreach ($data[3] as $acteur) {
                $serie->addActeur($this->getReference($acteur));
            }
            foreach ($data[4] as $genre) {

                $serie->addGenre($this->getReference($genre));
            }
            $serie->setImage($data[5]);

            $saison = new Saison();
            $saison->setNomSaison($data[6][0]);
            $saison->setDescriptionSaison($data[6][1]);
            $saison->setDateSortie(DateTime::createFromFormat('Y-m-j', $data[6][2]));
            $saison->setImage($data[6][3]);
            $saison->setSerie($serie);

            $episode = new Episode();
            $episode->setNomEpisode($data[6][4][0]);
            $episode->setDescriptionEpisode($data[6][4][1]);
            $episode->setDateSortie(DateTime::createFromFormat('Y-m-j',$data[6][4][2]));
            $episode->setImage($data[6][4][3]);
            $episode->setSaison($saison);

            $manager->persist($episode);
            $manager->persist($saison);
            $manager->persist($serie);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ActeurFixtures::class,
            GenreFixtures::class,
        );
    }
}
