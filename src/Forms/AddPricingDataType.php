<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 28/02/2017
 * Time: 22:59
 */

namespace VinylStore\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPricingDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('release_id', ChoiceType::class, array(
                'choices' => array(
                    array_combine($options['title'], $options['id'])
                )))
            ->add('release_name', TextType::class)
            ->add('price', MoneyType::class )
            ->add('url', UrlType::class, array(
                'default_protocol' => 'https'
            ))
            ->add('description', TextType::class)
            ;
    }

    public function getName()
    {
        return 'pricing';
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('id','title'));
        return $resolver;
    }
}