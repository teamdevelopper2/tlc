<?php

namespace Tlc\InventoryBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('reference')
            ->add('designation')
            ->add('price')
            ->add('category', EntityType::class, array(
                'class' => 'Tlc\InventoryBundle\Entity\Category',
                'choice_label' => 'name'
            ))
            ->add('provider', EntityType::class, array(
                'class' => 'Tlc\InventoryBundle\Entity\Provider',
                'choice_label' => 'name'
            ))
            ->add('file', FileType::class, ['required' => false]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tlc\InventoryBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tlc_inventorybundle_product';
    }


}
