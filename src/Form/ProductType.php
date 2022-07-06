<?php

namespace App\Form;

use App\Repository\TypeProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\BrandProduct;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Quantity')
            ->add('Price')
            ->add('Information')
            ->add('Brand', EntityType::class,[
                'class' => BrandProduct::class
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
