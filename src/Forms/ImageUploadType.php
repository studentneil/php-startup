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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('image', FileType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Image(array(
                        'mimeTypes' => array('image/jpg', 'image/png'),
                        'maxSize' => '3M',
                            )
                        ),
                    ),
                'multiple' => 'true',
            ));
    }
}
