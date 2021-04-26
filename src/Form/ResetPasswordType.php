<?php

namespace App\Form;

use App\Entity\ResetPassWord;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'disabled'=> true
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
                'constraints' => new Regex([
                                               'pattern' =>  '^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^',
                                               'match' => true,
                                               'message'=> "Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole."
                                           ]),
                'second_options' => [
                    'label' => 'Vueillez confirmer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmation de votre  nouveau mot de passe']
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
               'data_class' => ResetPassWord::class,
       ]);
    }
}
