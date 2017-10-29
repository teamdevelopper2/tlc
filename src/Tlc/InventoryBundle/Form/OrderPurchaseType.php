<?php

namespace Tlc\InventoryBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderPurchaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateOrder', DateType::class, array(
            'widget' => 'single_text',
            'html5' => false,
            // this is actually the default format for single_text
            'format' => 'dd/MM/yyyy',
            'attr' => array('class' => 'form-control' ,  'placeholder' => 'jj/mm/yyyy')
        ))
            ->add('provider', EntityType::class, array(
                'class' => 'Tlc\InventoryBundle\Entity\Provider',
                'choice_label' => 'name'
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tlc\InventoryBundle\Entity\OrderPurchase'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tlc_inventorybundle_orderpurchase';
    }


}
