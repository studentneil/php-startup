<?php
declare(strict_types=1);

namespace VinylStore\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('catalogue_number', SearchType::class, [
                'attr' => [
                    'placeholder' => 'Catalogue Number',
                ],
            ])
        ->
        add('title', SearchType::class, [
            'attr' => [
                'placeholder' => 'Title',
            ],
        ]);
    }

    public function getName(): String
    {
        return 'Search';
    }
}