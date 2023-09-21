<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('currentPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
            ])
            ->add('newPassword2', PasswordType::class, [
                'label' => 'Nouveau mot de passe réecris',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}



