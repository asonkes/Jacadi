<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Regex([
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
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^\D+$/',
                        'message' => 'Votre prénom ne peut pas contenir de chiffres.',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-mail',
                    'class' => 'j-form__input',
                    new NotBlank([
                        'message' => 'L\'adresse e-mail ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/@.*\.(com|be|net)$/i',
                        'message' => 'L\'adresse e-mail doit contenir un "@" et se terminer par ".com".',
                    ]),
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Message',
                    'class' => 'j-form__input',
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
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
