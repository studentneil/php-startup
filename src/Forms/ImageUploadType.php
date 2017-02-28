<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 10/01/2017
 * Time: 22:34.
 */

namespace VinylStore\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use VinylStore\Entity\ChoiceEntity;

class ImageUploadType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('image', FileType::class)
            ->add('name', TextType::class)
            ->add('release_id', ChoiceType::class, array(
                'choices' => array(
                    array_combine($options['title'], $options['id'])
                )
            ));
    }
    public function getName(){
        return 'image';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('id','title'));
        return $resolver;
    }

}
