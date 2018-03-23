<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 12/06/2017
 * Time: 23:03
 */

namespace VinylStore\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3,
                    ))
                )
            ))
            ->add('email', EmailType::class, array(
                'constraints' => new Assert\Email()
            ))
            ->add('message', TextareaType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                )
            ))
            ->add('field', TextType::class, array(
                'required' => false,
                'constraints' => array(
                    new Assert\Blank()
                )
            ));

    }

    public function getName()
    {
        return 'contact';
    }

}