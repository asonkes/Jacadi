<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert; // Importation des contraintes
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'j-form__input',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\D+$/',
                        'message' => 'Votre prénom ne peut pas contenir de chiffres.',
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'j-form__input',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\D+$/',
                        'message' => 'Votre nom ne peut pas contenir de chiffres.',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-mail',
                    'class' => 'j-form__input',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'adresse e-mail ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/@.*\.(com|be|net)$/i',
                        'message' => 'L\'adresse e-mail doit contenir un "@" et se terminer par ".com", ".be" ou ".net".',
                    ]),
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Message',
                    'class' => 'j-form__input',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Le champ doit comporter au moins {{ limit }} caractères.',
                        'max' => 200,
                        'maxMessage' => 'Le champ doit comporter au maximum {{ limit }} caractères.',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'j-form__button'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
