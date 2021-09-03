<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new Utilisateur();
        $user->setUsername('Angel');
        $plainPassword = "Azerty123";
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->addRole('ROLE_ADMIN');
        $user->setEmail('testAdmin@gmail.com');
        $user->setDateCreation(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($user);

        $user = new Utilisateur();
        $user->setUsername('Angel1');
        $plainPassword = "Azerty123";
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->addRole('ROLE_USER');
        $user->setEmail('testUser@gmail.com');
        $user->setDateCreation(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($user);

        $manager->flush();
    }
}
