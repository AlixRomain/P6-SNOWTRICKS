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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fname', TextType::class, array(
                'label' => 'Nom d\'utilisateur',
            ))
            ->add('lname', TextType::class, array(
                'label' => 'Nom d\'utilisateur',
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
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
