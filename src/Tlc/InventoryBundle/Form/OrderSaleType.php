<?php

namespace Tlc\InventoryBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tlc\InventoryBundle\Entity\Client;

class OrderSaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('dateOrder', DateType::class, array(
              'widget' => 'single_text',
              'html5' => false,
              'format' => 'dd/MM/yyyy',
              ))
           ->add('client', EntityType::class, array(
              'class' => Client::class,
              'choice_label' => 'fisrtname'
           ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tlc\InventoryBundle\Entity\OrderSale'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tlc_inventorybundle_ordersale';
    }


}
