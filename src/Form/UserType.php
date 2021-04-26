<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fname', TextType::class, array(
                'label' => 'Nom d\'utilisateur',
                'constraints' => new Length([
                                    'min' => 2,
                                    'max' => 15
                                ])
            ))
            ->add('lname', TextType::class, array(
                'label' => 'Nom d\'utilisateur',
                'constraints' => new Length([
                                    'min' => 2,
                                    'max' => 15
                                ])
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'constraints' => new Length([
                                    'max' => 60
                                ])
            ))
            ->add('file', FileType::class, array(
                'label' => false,
                'required' => false,
                'data_class' => null
            ))
            ->add('devise', TextareaType::class, array(
                'label' => 'devise',
                'required' => false,
            ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
