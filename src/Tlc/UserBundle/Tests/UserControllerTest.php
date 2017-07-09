<?php

namespace Tlc\UserBundle\Tests;

use Doctrine\ORM\EntityRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Tlc\UserBundle\DataFixtures\ORM\LoadProfilData;
use Tlc\UserBundle\DataFixtures\ORM\LoadUserData;
use Tlc\UserBundle\Entity\Profil;

class UserControllerTest extends WebTestCase
{
   /**
    * Test uppercase of role when persit user
    */
   public function testUppercaseRoleOfUser(){

      $em = $this->getContainer()->get('doctrine.orm.entity_manager');
      $user = $this->getFixtues()->getReference('bobo');

      $this->assertTrue(in_array('ROLE_USER', $user->getRoles()));
      $user->addRole(new Profil('role_cli'));
      $em->persist($user);
      $em->flush();

      $this->assertTrue(in_array('ROLE_CLI', $user->getRoles()));
   }

   /**
    * Test list user
    */
   public function testListUser()
   {
      $this->connect();
      $client = $this->makeClient();

      $client->request('GET', '/admin/user/list');
      $this->assertStatusCode(200, $client);
   }

   /**
    * Test l'ajout d'un utilisateur
    */
   public function testAddUser(){
      $em = $this->getContainer()->get('doctrine')->getManager();

      $this->connect();
      $client = $this->makeClient();

      $crawler = $client->request('GET', '/admin/user/add');
      $response = $client->getResponse();

      $this->assertStatusCode(200, $client);
      $this->assertSame('application/json', $response->headers->get('Content-Type'));

      // Post user
      $crawler = $client->request('GET', '/');
      $button = $crawler->filter('a:contains("Admin")')->eq(0)->link();
      $this->assertTrue($button != null);

      $crawler = $client->click($button);
      $button = $crawler->filter('a:contains("Utilisateur")')->eq(0)->link();
      $this->assertTrue($button != null);

//      $form = $crawler->selectButton('Ajouter')->form();
//      $form->setValues([
//         'userbundle_user[username]'      => 'boura',
//         'userbundle_user[email]'         => 'boura@gmail.com',
//         'userbundle_user[plainPassword]' => 'bdiallo'
//
//      ]);
//      $client->submit($form);
//      $this->assertStatusCode('200', $client);

      // Verify count of user saved
//      $this->assertCount(2, $em->getRepository('UserBundle:User')->findAll());
   }

   public function connect(){
      $user = $this->getFixtues()->getReference('bobo');
      $this->loginAs($user, 'main');
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