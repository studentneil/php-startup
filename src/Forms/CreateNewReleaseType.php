<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 07/01/2017
 * Time: 00:53
 */

namespace VinylStore\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateNewReleaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('catalog', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 4,
                        'max' => 9
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'eg 12 brw'
                )
            ))
            ->add('artist', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. Tricky'
                )
            ))
            ->add('title', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'eg.tricky kid'
                )
            ))
            ->add('label', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
                'attr' => array(
                    'placeholder' => 'e.g. sony'
                )
            ))
            ->add('format', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
                'attr' => array(
                    'placeholder' => 'e.g. 12" LP'
                )
            ))
            ->add('released', DateType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\DateValidator(array(

                    ))
                ),
                'attr' => array(
                    'placeholder' => 'eg 11/12/1975'
                )
            ))
            ->add('date_added', DateType::class, array(

                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\DateTime()

                ),
                'attr' => array(
                    'placeholder' => 'eg. now',
                    'class' => 'date'
                )
            ))
            ->add('media_condition', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. VG'
                )
            ))
            ->add('sleeve_condition', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. mint'
                )
            ))
            ->add('notes', TextAreaType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),

                ),
                'attr' => array(
                    'placeholder' => 'e.g. great album etc'
                )
            ))
            ->add('genre', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),

                ),
                'attr' => array(
                    'placeholder' => 'eg rock'
                )
            ))
            ->add('image', FileType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),

                ),
                'attr' => array(
                    'placeholder' => 'image file'
                )
            ));
    }

}