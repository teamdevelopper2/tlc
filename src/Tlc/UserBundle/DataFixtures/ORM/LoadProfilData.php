<?php

namespace Tlc\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tlc\UserBundle\Entity\Profil;

class LoadProfilData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

   /**
    * Load data fixtures with the passed EntityManager
    *
    * @param ObjectManager $manager
    */
   public function load(ObjectManager $manager)
   {
      $profil = new Profil('ROLE_ADMIN');
      $manager->persist($profil);

      $profil1 = new Profil('ROLE_FOURNISSEUR');
      $manager->persist($profil1);

      $manager->flush();

      $this->addReference('role_admin', $profil);
      $this->addReference('role_fournisseur', $profil1);
   }

   public function getOrder(){
      return 1;
   }
}