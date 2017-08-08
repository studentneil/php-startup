<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 08/08/2017
 * Time: 23:06
 */

namespace VinylStore\Forms;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShippingRatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('quantity', NumberType::class)
            ->add('cost', MoneyType::class)
            ->add('description', TextType::class);
    }
    public function getName()
    {
        return 'shipping';
    }
}