<?php
namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['entity_manager'];

        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>3, 'max' => 255]),
                ],
            ])
            ->add('login', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>3,'max' => 128]),
//                    new UniqueEntity([
//                        'fields' => ['login'],
//                        'entityClass' => new User,
//                        //'em' => $entityManager,
//                        //'repositoryMethod' => 'findOneByLogin',
//                    ])
                ],
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>3,'max' => 255]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>3,'max' => 128]),
                    new Email(),
//                    new UniqueEntity([
//                        'fields' => 'email',
//                        'entityClass' => new User,
//                        'em' => 'default',
//                        'repositoryMethod' => 'findOneByEmail',
//                    ])
                ],
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>1,'max' => 15]),
                ],
            ])
            ->add('skype', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['min'=>1,'max' => 128]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);

        $resolver->setRequired('entity_manager');
    }
}