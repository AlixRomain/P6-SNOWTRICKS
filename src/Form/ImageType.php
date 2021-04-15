<?php

namespace App\Form;

use App\Entity\Media;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', FileType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre image',
                    'class' => 'img-trick'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Media::class,
                                   /*'query_builder' => function (EntityRepository $repo) {
                                       return $repo->createQueryBuilder('m')
                                           ->where('m.type == :toto')
                                           ->setParameter('toto', 'img');
                                   }*/
                               ]);
    }
}

