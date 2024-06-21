<?php

namespace App\Form;

use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StockFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('size', TextType::class, [
                'label' => 'Taille',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Positive(
                        message: 'La taille ne peut pas être négative'
                    )
                ]
            ])
            ->add('stockProducts', IntegerType::class, [
                'label' => 'Quantité en stock',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide'
                    ]),
                    new Range([
                        'min' => 0,
                        'notInRangeMessage' => 'Le stock ne peut pas être négatif'
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
