<?php

namespace Tlc\UserBundle\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use Tlc\UserBundle\DataFixtures\ORM\LoadProfilData;
use Tlc\UserBundle\DataFixtures\ORM\LoadUserData;

class SecurityControllerTest extends WebTestCase
{

   /**
    * Test la protection des routes ^/admin pour les users anonymes
    */
   public function testAccessDenied()
   {
      $client = $this->makeClient();
      $client->request('GET', '/admin/user/list');
      $this->assertStatusCode('302', $client);
   }

   /**
    * Test l'authentification
    */
   public function testAuthentication(){

      $user = $this->getFixtues()->getReference('bobo');

      $this->loginAs($user, 'main');
      $client = $this->makeClient();
      $client->request('GET', '/admin/user/list');
      $this->assertStatusCode('200', $client);
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
