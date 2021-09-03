<?php

namespace App\Form;

use App\Entity\Acteur;
use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ActeursType extends AbstractType
{
    private TokenStorageInterface $tokenStorage;
    private $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage; // le token utilisateur
        $this->authorizationChecker = $authorizationChecker; // le service de controle d'utilisateur
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameActor')
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );
    }
        public function onPreSetData(FormEvent $event){
            $form = $event->getForm(); //récupération du formulaire

            /** @var $entity Serie */
            $entity = $event->getData(); //récupération de l'entité

            if($this->authorizationChecker->isGranted('ROLE_ADMIN') === true && $entity->getId() != null)//si je suis en édition
            {
                $form->remove('nameActor');
            }
        }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Acteur::class,
        ]);
    }
}
