<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>3, 'max' => 128]),
                ],
            ])
            ->add('numberPlate', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>3,'max' => 10]),
                ],
            ])
            ->add('color', ColorType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['min'=>4,'max' => 7]),
                ],
            ])
            ->add('year', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new Range(['min' => 1990, 'max' => date("Y")])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'constraints'     => [
                new UniqueEntity(['fields' => ['numberPlate']]),
            ],
            'csrf_protection' => false,
        ]);
    }
}