<?php

namespace Tlc\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tlc\UserBundle\Entity\Profil;

class ProfilType extends AbstractType
{

   public function buildForm(FormBuilderInterface $builder, array $options)
   {
      $builder
         ->add('role')
         ->add('description');
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'data_class' => Profil::class
      ]);
   }

   public function getBlockPrefix()
   {
      return 'userbundle_profil';
   }

}