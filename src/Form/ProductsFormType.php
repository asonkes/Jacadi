<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Length(
                        [
                            'min' => 8,
                            'minMessage' => "Le champ doit comporter au minimum 8 caractères",
                            'max' => 200,
                            'maxMessage' => 'Le champ doit comporter au maximum 200 caractères'
                        ]
                    )
                ]
            ])
            ->add('price', options: [
                'label' => 'Prix',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Positive(
                        message: 'Le prix ne peut-être négatif'
                    )
                ]
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxWidth' => '1500',
                        'maxWidthMessage' => "L'image ne doit pas faire plus de 1500 pixels de large."
                    ])
                ]
            ])
            ->add('content', options: [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Length(
                        [
                            'min' => 50,
                            'minMessage' => "Le champ doit comporter au minimum 50 caractères",
                            'max' => 200,
                            'maxMessage' => 'Le champ doit comporter au maximum 200 caractères'
                        ]
                    )
                ]
            ])
            ->add('composition', options: [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Length(
                        [
                            'min' => 10,
                            'minMessage' => "Le champ doit comporter au minimum 10 caractères",
                            'max' => 200,
                            'maxMessage' => 'Le champ doit comporter au maximum 200 caractères'
                        ]
                    )
                ]
            ])
            ->add('advices', options: [
                'label' => "Conseils d'entretien",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Length(
                        [
                            'min' => 20,
                            'minMessage' => "Le champ doit comporter au minimum 20 caractères",
                            'max' => 200,
                            'maxMessage' => 'Le champ doit comporter au maximum 200 caractères'
                        ]
                    )
                ]
            ])
            ->add('eco', options: [
                'label' => 'Articles responsables',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Length(
                        [
                            'min' => 20,
                            'minMessage' => "Le champ doit comporter au minimum 20 caractères",
                            'max' => 200,
                            'maxMessage' => 'Le champ doit comporter au maximum 200 caractères'
                        ]
                    )
                ]
            ])
            ->add(
                'categories',
                EntityType::class,
                [
                    'class' => Categories::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'group_by' => 'parent.name',
                    'query_builder' => function (CategoriesRepository $cr) {
                        return $cr->createQueryBuilder('c')
                            ->where('c.parent IS NOT NULL')
                            ->orderBy('c.name', 'ASC');
                    },
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le choix des cétagories ne peut pas être vide'
                        ]),
                        new Count([
                            'min' => 2,
                            'minMessage' => 'Vous devez choisir au moins deux catégories.'
                        ]),
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
