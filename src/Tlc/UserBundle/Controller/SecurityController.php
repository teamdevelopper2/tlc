<?php

namespace Tlc\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{

   /**
    * @Route(name="user_list", path="/list/user")
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function getUsersAction()
   {
      $users = $this->getDoctrine()
         ->getManager()
         ->getRepository('UserBundle:User')
         ->findAll();
      return $this->render(':admin:list_user.html.twig', ['users' => $users]);
   }
}
