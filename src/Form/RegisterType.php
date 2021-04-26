<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname', TextType::class, array(
                'required' => true,
                'label' => 'Votre prénom',
                'constraints' => new Length([
                                    'min' => 2,
                                    'max' => 15
                                ]),
                'attr' => [
                    'placeholder' => 'Martin']

            ))
            ->add('lname', TextType::class, array(
                'required' => true,
                'label' => 'Votre nom',
                'constraints' => new Length([
                                    'min' => 2,
                                    'max' => 15
                                ]),
                'attr' => [
                    'placeholder' => 'Dupont']
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'Email',
                'constraints' => new Length([
                                    'max' => 60
                                ]),
                'attr' => [
                    'placeholder' => 'Martin@Dupont.snowtricks']
            ))
            ->add('devise',TextType::class, [
                'required' => false,
                'label'   => 'Une devise ?',
                'attr' => [
                    'placeholder' => 'Née pour rider']
            ])
            ->add('file', FileType::class, array(
                'label' => false,
                'required' => false,
                'data_class' => null,
            ))

            ->add('password', RepeatedType::class, [
                'type'   => PasswordType::class,
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
