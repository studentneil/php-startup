<?php

namespace App\Form;

use App\Domain\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('catalogNumber', SearchType::class, [
                'attr' => [
                    'placeholder' => 'Catalogue Number',
                    ],
                ])
            ->add('title', SearchType::class, [
                'attr' => [
                    'placeholder' => 'Title',
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class
        ]);
    }
}
