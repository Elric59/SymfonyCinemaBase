<?php
namespace App\DataFixtures;

use App\Entity\Film;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FilmFixture extends Fixture implements DependentFixtureInterface
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
            array(
                "Le jardin des fleurs",
                'un simple jardin renfermant un terrible secret',
                "2020-08-12",
                ['Billy', 'Philibert'],
                ['Romance'],
                "6280423.jpeg"
                ),
            array(
                "Le café de l'horreur",
                "un café qui rend fou ",
                "2021-03-12",
                ['Philibert'],
                ['Horreur'],
                "4376212.jpeg"
            )
        );

        foreach ($datas as $data) {
            $film = new Film();
            $film->setNomFilm($data[0]);
            $film->setDescriptionFilm($data[1]);
            $film->setDateSortie(DateTime::createFromFormat('Y-m-j', $data[2]));
            foreach ($data[3] as $acteur) {
                $film->addActeur($this->getReference($acteur));
            }
            foreach ($data[4] as $genre) {

                $film->addGenre($this->getReference($genre));
            }
            $film->setImage($data[5]);
            $manager->persist($film);
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
