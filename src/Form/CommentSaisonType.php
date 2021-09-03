<?php

namespace App\Form;

use App\Entity\CommentaireSaison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class CommentSaisonType extends AbstractType
{
    private $tokenStorage;
    private  $authorizationChecker;
    private $saison;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->saison = $options["saison"];

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
        $comments = $event->getData();
        $comments->setUser($this->tokenStorage->getToken()->getUser());
        if($this->saison != null){ //on verifie que la valeur n'est pas null
            $comments->setSaison($this->saison);
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommentaireSaison::class,
            'saison' => null,
        ]);
    }
}
