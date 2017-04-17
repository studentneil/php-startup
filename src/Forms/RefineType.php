<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 17/04/2017
 * Time: 00:13
 */

namespace VinylStore\Forms;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;


class RefineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('genre', ChoiceType::class, array(
                'choices' => array(
                    'rock' => 'rock',
                    'electronic' => 'electronic',
                    'classic rock' => 'classic_rock'
                ),
                'multiple' => true,
                'expanded' => true
            ))
            ->add('format', ChoiceType::class, array(
                'choices' => array(
                    '12" Lp' => '12" Lp',
                    '12" Single' => '12" Single',
                    '7" Single' => '7" Single'
                ),
                'multiple' => true,
                'expanded' => true
            ));
    }

    public function getName()
    {
        return 'refine';
    }

}