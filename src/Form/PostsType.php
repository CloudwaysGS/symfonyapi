<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

            $builder
                ->add('titre', null, [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 3]),
                    ],
                ])
                ->add('contenu', null, [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 10]),
                    ],
                ])
                ->add('auteur', null, [
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])
                ->add('email', EmailType::class, [
                    'constraints' => [
                        new NotBlank(),
                        new Email(),
                    ],
                ]);
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            dd("ok");
            $form = $event->getForm();
            $data = $event->getData();
            dd("ok");
            // Effectuez ici vos validations personnalisées
            // Utilisez le composant Validator pour appliquer des contraintes de validation sur les données du formulaire.

            // Par exemple, pour valider le champ 'email' comme une adresse e-mail :
            $email = $data['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $form->get('email')->addError(new FormError('L\'adresse e-mail n\'est pas valide.'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
