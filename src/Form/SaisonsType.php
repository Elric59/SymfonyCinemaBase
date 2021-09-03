<?php

namespace App\Form;


use App\Entity\Saison;
use App\Entity\Serie;
use App\Repository\SerieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraints\File;

class SaisonsType extends AbstractType
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
            ->add('nomSaison')
            ->add('descriptionSaison')
            ->add('dateSortie',DateType::class, [ //calendrier
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('image', FileType::class, [ //récup l'image
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
            ->add('serie',EntityType::class,array( //recupe serie
                'label'=>'Serie',
                'class' => Serie::class,
                'choice_label' => 'nomSerie',
                'query_builder' => function (SerieRepository $serieRepository) use ($options){
                    return $serieRepository->getSeries();
                },
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'form-control')
            ));

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Saison::class,
        ]);
    }
}
