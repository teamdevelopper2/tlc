<?php

namespace Tlc\UserBundle\Tests\Controller;


use Doctrine\ORM\EntityRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Tlc\UserBundle\DataFixtures\ORM\LoadProfilData;
use Tlc\UserBundle\DataFixtures\ORM\LoadUserData;
use Tlc\UserBundle\Entity\Profil;

class SecurityControllerTest extends WebTestCase
{

   /**
    * Test la protection des routes ^/admin pour les users anonymes
    */
   public function testAccessDenied()
   {
      $client = $this->makeClient();
      $client->request('GET', '/admin/list/user');
      $this->assertStatusCode('302', $client);
   }

   /**
    * Test l'authentification
    */
   public function testAuthentication(){

      $user = $this->getFixtues()->getReference('bobo');

      $this->loginAs($user, 'main');
      $client = $this->makeClient();
      $client->request('GET', '/admin/list/user');
      $this->assertStatusCode('200', $client);
   }

   public function testUppercaseRoleOfUser(){

      $em = $this->getContainer()->get('doctrine.orm.entity_manager');

      $user = $this->getFixtues()->getReference('bobo');

      $this->assertTrue(in_array('ROLE_USER', $user->getRoles()));
      $user->addRole(new Profil('role_cli'));
      $em->persist($user);
      $em->flush();

      $this->assertTrue(in_array('ROLE_CLI', $user->getRoles()));
   }


   private function getMockerUser(){
      $userRepository = $this->getMockBuilder(EntityRepository::class)
         ->disableOriginalConstructor()
         ->getMock();
   }


   /**
    * Load the fixtues
    *
    * @return \Doctrine\Common\DataFixtures\ReferenceRepository
    */
   private function getFixtues(){
      return $this->loadFixtures([
         LoadProfilData::class,
         LoadUserData::class
      ])->getReferenceRepository();
   }
}
