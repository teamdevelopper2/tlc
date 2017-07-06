<?php

namespace Tlc\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tlc\UserBundle\Entity\Profil;

class LoadProfilData extends AbstractFixture implements FixtureInterface
{

   /**
    * Load data fixtures with the passed EntityManager
    *
    * @param ObjectManager $manager
    */
   public function load(ObjectManager $manager)
   {
      $profil = new Profil('ROLE_USER');
      $this->addReference('role_user', $profil);
      $manager->persist($profil);

      $profil = new Profil('ROLE_ADMIN');
      $this->addReference('role_admin', $profil);
      $manager->persist($profil);

      $manager->flush();
   }

   public function getOrder(){
      return 1;
   }
}