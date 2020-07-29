<?php

namespace App\Form;

use App\Entity\Software;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SoftwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('author')
            ->add('authorEmail')
            ->add('authorUrl')
            ->add('filename')
            ->add('version')
            ->add('fileSize')
            ->add('image', FileType::class, [
                'label' => 'Selectionner une image :',
                'required' => false,
                'data_class' => null
            ])
            ->add('description')
            ->add('category', null, ['choice_label' => 'name', 'label' => "Catégorie : "])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Software::class,
        ]);
    }
}
