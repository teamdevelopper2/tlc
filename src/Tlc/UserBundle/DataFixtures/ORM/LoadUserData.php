<?php

namespace Tlc\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tlc\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
   /**
    * @var ContainerInterface
    */
   protected $container;

   /**
    * Sets the container.
    *
    * @param ContainerInterface|null $container A ContainerInterface instance or null
    */
   public function setContainer(ContainerInterface $container = null)
   {
      $this->container = $container;
   }

   /**
    * Load data fixtures with the passed EntityManager
    *
    * @param ObjectManager $manager
    */
   public function load(ObjectManager $manager)
   {
      $encoder = $this->container->get('security.password_encoder');

      $user = new User();
      $user->setUsername('bobo');
      $user->setEmail('bobo@gmail.com');
      $user->setPassword($encoder->encodePassword($user, 'bdiallo'));
      $user->setEnabled(true);
      $user->setRoles([
         $this->getReference('role_admin'),
         $this->getReference('role_fournisseur')
      ]);
      $this->addReference('bobo', $user);
      $manager->persist($user);
      $manager->flush();
   }

   public function getOrder(){
      return 2;
   }
}