<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Tricks;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TricksUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choice = [];
        foreach ($options['categorie'] as $val){
            array_push($choice,[ $val->getName() =>  $val->getCategoryParent()]);
        };

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du tricks',
                'attr' => [
                    'placeholder' => 'Titre du tricks',
                    'rows' => 3
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description du tricks',
                ],
            ])
            ->add('file', FileType::class, [
                'label' => false,
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'placeholder' => 'Ajouter ou modifier l\'image principale du tricks',
                ],
            ])

            ->add('category', EntityType::class, [
                'class'  => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('c')
                        ->where('c.category_parent != :toto')
                        ->setParameter('toto', '0');
                },
                'label'     => false,
                'multiple'  => 3,
                'attr' => ['class' => 'minHeightSelect'],
                'group_by' => function($choice, $key, $value) {
                    return ucfirst($choice->getCategoryParent()) ;
                }
            ])

           ->add('media', CollectionType::class, [
                'required' => false,
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'block_name' => 'image',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])

            ->add('videos', CollectionType::class, [
            'required' => false,
            'entry_type' => VideoType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
        $resolver->setRequired([
            'categorie'
        ]);
    }
}
