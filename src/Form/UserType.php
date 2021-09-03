<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('avatar')
            //initialement la description, remplacée par l'avatar
            ->add('avatar', FileType::class, [ //recup l'image
                'label' => 'importer un avatar',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci d\'uploader une image compatible, merci',
                    ])
                ],
            ])
            ;

        if($options['style'] === 'register'){
            $builder->remove('roles')->remove('password')->remove('avatar')->remove('created_at');
            $builder->add('plainPassword', PasswordType::class,
                [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [new NotBlank()]
                ]);
        }

        $builder->add(
            'submit',
            SubmitType::class,
            ['label' => 'S\'inscrire', 'attr' => ['class' => 'btn btn-success']]
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            [$this, 'onPreSetData']
        );


    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity Utilisateur */

        $entity = $event->getData(); //récupération de l'entité
        if($entity->getId() != null){
            $form->remove('roles');
            $form->remove('submit');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Utilisateur::class,
                'style' => 'null',
            ]
        );
    }
}
