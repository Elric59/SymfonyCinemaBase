<?php

namespace App\Form;


use App\Entity\SauvegardeFilm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SauvegardeFilmType extends AbstractType
{
    private TokenStorageInterface $tokenStorage;
    private $authorizationChecker;
    private  $film;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage; // le token utilisateur
        $this->authorizationChecker = $authorizationChecker; // le service de controle d'utilisateur
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->film = $options["film"];

        $builder
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );
    }
        public function onPreSetData(FormEvent $event){

            /** @var $entity SauvegardeFilm */
            $save = $event->getData(); //récupération de l'entité

            $save->setUtilisateur($this->tokenStorage->getToken()->getUser());
            $save->setFilm($this->film);
        }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SauvegardeFilm::class,
            'film' => $this->film,
        ]);
    }
}
