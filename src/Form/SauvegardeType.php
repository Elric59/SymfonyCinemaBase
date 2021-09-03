<?php

namespace App\Form;


use App\Entity\SauvegardeSerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SauvegardeType extends AbstractType
{
    private TokenStorageInterface $tokenStorage;
    private $authorizationChecker;
    private  $serie;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage; // le token utilisateur
        $this->authorizationChecker = $authorizationChecker; // le service de controle d'utilisateur
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->serie = $options["series"];

        $builder
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );
    }
        public function onPreSetData(FormEvent $event){

            /** @var $entity SauvegardeSerie */
            $save = $event->getData(); //récupération de l'entité

            $save->setUtilisateur($this->tokenStorage->getToken()->getUser());
            $save->setSerie($this->serie);
        }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SauvegardeSerie::class,
            'series' => $this->serie,
        ]);
    }
}
