<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Entrez votre e-mail',
                'attr' => [
                    'placeholder' => 'jacadi@gmail.com',
                    'constraints' => [
                        new Email([
                            'message' => 'Veuillez entrer une adresse e-mail valide.',
                            'mode' => 'strict',
                        ]),
                        new NotBlank([
                            'message' => 'L\'adresse e-mail ne peut pas être vide.',
                        ]),
                        new Regex([
                            'pattern' => '/@.*\.com$/i',
                            'message' => 'L\'adresse e-mail doit contenir un "@" et se terminer par ".com".',
                        ]),
                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
