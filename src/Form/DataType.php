<?php

namespace App\Form;

use App\Entity\Data;
use App\Entity\User;
use App\Enum\Product;
use App\Enum\Color;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EnumType::class, [
                'class' => Product::class,
                'label' => 'Product',
                'placeholder' => 'Select product',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('color', EnumType::class, [
                'class' => Color::class,
                'label' => 'Color',
                'required' => false,
                'placeholder' => '---',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('amount', IntegerType::class, [
                'label' => 'Amount',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Data::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'data_item',
        ]);
    }
}
