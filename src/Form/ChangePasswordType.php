<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password',PasswordType::class, [
                'label'   => 'Saisisser votre mot de passe actuel',
                'attr' => [
                    'placeholder' => 'Mot de passe que vous-souhaitez modifier'],
                'mapped'  => false
            ])
            ->add('new_password', RepeatedType::class, [
                'type'   => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'options'  => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Entrer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Mot de passe'],
                ],
                'second_options' => [
                    'label' => 'Vueillez confirmer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmation de votre  nouveau mot de passe'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
