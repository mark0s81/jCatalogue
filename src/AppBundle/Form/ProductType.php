<?php
/**
 * Created by PhpStorm.
 * User: markos
 * Date: 15.05.17
 * Time: 17:39
 */

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('image', FileType::class, array(
                'label' => 'Image (JPG or PNG file)',
                'data_class' => null,
                'required' => is_null($builder->getData()->getId())
            ))
            ->add('description', TextType::class)
            ->add('tag', EntityType::class, array(
                'class' => 'AppBundle:Tag',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Tags',
                'attr'   =>  ['class'   => 'tag']
            ))
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class
        ));
    }
}