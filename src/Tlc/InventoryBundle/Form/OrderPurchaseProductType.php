<?php

namespace Tlc\InventoryBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tlc\InventoryBundle\Entity\Product;

class OrderPurchaseProductType extends AbstractType
{
   /**
    * {@inheritdoc}
    */
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
      $builder
         ->add('product', EntityType::class, array(
            'class' => Product::class,
            'choice_label' => 'designation'
         ))
//            ->add('orderSale', EntityType::class, array(
//                'class' => OrderSale::class,
//                'choice_label' => 'id'
//            ))
         ->add('amount', IntegerType::class);
   }

   /**
    * {@inheritdoc}
    */
   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults(array(
         'data_class' => 'Tlc\InventoryBundle\Entity\OrderPurchaseProduct'
      ));
   }

   /**
    * {@inheritdoc}
    */
   public function getBlockPrefix()
   {
      return 'tlc_inventorybundle_orderpurchaseproduct';
   }
}