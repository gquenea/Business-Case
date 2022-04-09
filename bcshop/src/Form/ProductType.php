<?php

namespace App\Form;

use App\Entity\Product;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('brand')
            ->add('quantity')
            ->add('isActive')
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'name'
            ])
            ->add('image',CollectionType::class, [
                'entry_type'=>ImageType::class,
                'entry_options' => ['label' => false],
                'allow_add'=>true,
                'allow_delete'=>true,
                'required'=>false,
                'by_reference'=>false,
                'disabled'=>false,
                'prototype'=>true,
                'label'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
