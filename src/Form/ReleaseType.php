<?php

namespace App\Form;

use App\Entity\Release;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReleaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artist')
            ->add('title')
            ->add('catalogNumber')
            ->add('label')
            ->add('format')
            ->add('mediaCondition')
            ->add('sleeveCondition')
            ->add('notes')
            ->add('genre')
            ->add('quantity')
            ->add('barcode')
            ->add('releaseDate', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Release::class,
        ]);
    }
}
