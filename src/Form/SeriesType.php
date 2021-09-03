<?php

namespace App\Form;

use App\Entity\Acteur;
use App\Entity\Genre;
use App\Entity\Serie;
use App\Repository\ActeurRepository;
use App\Repository\GenreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraints\File;

class SeriesType extends AbstractType
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
            ->add('nomSerie')
            ->add('descriptionSerie')
            ->add('dateSortie',DateType::class, [ //calendrier
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('image', FileType::class, [ //recupe l'image
                'label' => "importer l'affiche de la série",
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
            ->add('acteur',EntityType::class,array( //recup les acteurs
                'label'=>'Nom Acteur',
                'class' => Acteur::class,
                'choice_label' => 'NameActor',
                'query_builder' => function (ActeurRepository $acteurRepository) use ($options){
                    return $acteurRepository->getActeurs();
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('genre',EntityType::class,array( //recup les genre
                'label'=>'Genre',
                'class' => Genre::class,
                'choice_label' => 'nomGenre',
                'query_builder' => function (GenreRepository $genreRepository) use ($options){
                    return $genreRepository->getGenres();
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => array('class' => 'form-control')
            ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
