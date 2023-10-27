<?php

namespace App\Form;

use App\Entity\Register;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;  // Fixed typo here

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [  // Fixed typo here
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('password', TextType::class, [  // Fixed typo here
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('role', TextType::class, [  // Fixed typo here
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Register::class,
        ]);
    }
}

