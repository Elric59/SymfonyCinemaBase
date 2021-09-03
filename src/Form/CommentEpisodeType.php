<?php

namespace App\Form;

use App\Entity\CommentaireEpisode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class CommentEpisodeType extends AbstractType
{
    private $tokenStorage;
    private  $authorizationChecker;
    private $episode;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->episode = $options["episode"];

        $builder
            ->add('descriptif')
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )

        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $comments = $event->getData(); //récupération de l'entité
        $comments->setUser($this->tokenStorage->getToken()->getUser());
        if($this->episode != null){ //on verifie que la valeur n'est pas null
            $comments->setEpisode($this->episode);
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommentaireEpisode::class,
            'episode' => null,
        ]);
    }
}
