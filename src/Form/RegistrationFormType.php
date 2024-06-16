<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'jacadi@gmail.com'
                ],
                'constraints' => [
                    new Assert\Email([
                        'message' => 'Veuillez entrer une adresse e-mail valide.',
                        'mode' => 'strict',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'L\'adresse e-mail ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/@.*\.com$/i',
                        'message' => 'L\'adresse e-mail doit contenir un "@" et se terminer par ".com".',
                    ]),
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\D+$/',
                        'message' => 'Votre nom ne peut pas contenir de chiffres.',
                    ]),
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\D+$/',
                        'message' => 'Votre prénom ne peut pas contenir de chiffres.',
                    ]),
                ]
            ])
            ->add('validerLesConditionsDeConfidentialite', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Valider les conditions de confidentialité',
                'constraints' => [
                    new Assert\IsTrue([
                        'message' => 'Vous devez accepter nos conditions générales.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => "Veuillez ajouter votre mot de passe.",
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
                        'message' => 'Votre mot de passe doit contenir au moins une majuscule et un caractère spécial (@, $, !, %, *, ?, &).',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
