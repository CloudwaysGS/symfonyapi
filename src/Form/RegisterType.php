<?php

namespace App\Form;

use App\Entity\Register;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'Username ne peut pas être vide'])],
            ])
            ->add('password', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'Password ne peut pas être vide'])],
            ])

            ->add('role', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'role ne peut pas être vide'])],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Register::class,
        ]);
    }
}
