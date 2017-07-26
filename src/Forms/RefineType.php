<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 17/04/2017
 * Time: 00:13.
 */

namespace VinylStore\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RefineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('genre', ChoiceType::class, array(
                'choices' => array(
                    'rock' => 'rock',
                    'electronic' => 'electronic',
                    'classic rock' => 'classic-rock',
                ),
                'multiple' => true,
                'expanded' => true,
                'empty_data' => null,
            ))
            ->add('format', ChoiceType::class, array(
                'choices' => array(
                    '12" double Lp' => '12" double Lp',
                    '12" e.p' => '12" e.p',
                    '12" Lp' => '12" Lp',
                    '12" single' => '12" single',
                    '7" single' => '7" single',
                ),
                'multiple' => true,
                'expanded' => true,
                'empty_data' => null,
            ));
    }

    public function getName()
    {
        return 'refine';
    }
}
