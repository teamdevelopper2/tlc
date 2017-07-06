<?php

namespace Tlc\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tlc\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
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

      $user1 = new User();
      $user1->setUsername('bobo');
      $user1->setEmail('bobo@gmail.com');
      $user1->setPassword($encoder->encodePassword($user1, 'bdiallo'));
      $user1->setEnabled(true);
      $user1->addRole($this->getReference('role_user'));
      $this->addReference('bobo', $user1);
      $manager->persist($user1);

      $user2 = new User();
      $user2->setUsername('boura');
      $user2->setEmail('boura@gmail.com');
      $user2->setPassword($encoder->encodePassword($user2, 'boura'));
      $user2->setEnabled(true);
      $user2->addRole($this->getReference('role_admin'));
      $this->addReference('boura', $user2);
      $manager->persist($user2);

      $manager->flush();
   }

   public function getOder(){
      return 2;
   }
}