<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('price')
            ->add('sku')
            ->add('pictureUrl', FileType::class, [
                'label' => 'Télécharger une photo pour le produit',
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/jpeg, image/png',
                ],
                'data' => null
            ])
            ->add('dateAdd')
            ->add('stock')
            ->add('collection')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
