<?php

namespace Tlc\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tlc\UserBundle\Entity\User;
use Tlc\UserBundle\Form\UserType;

class UserController extends \FOS\UserBundle\Controller\SecurityController
{

   /**
    * @Route(name="user_index", path="user/index", options={"expose"=true})
    */
   public function indexAction()
   {
      $users = $this->get('fos_user.user_manager')->findUsers();

      return new JsonResponse([
         'view' => $this->renderView(':admin:index.html.twig', ['users' => $users]),
         'error' => null
      ]);
   }

   /**
    * @Route(name="user_list", path="/user/list", options={"expose"=true})
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function listUsersAction()
   {
      $users = $this->getDoctrine()
         ->getManager()
         ->getRepository('UserBundle:User')
         ->findBy([], ['id' => 'DESC']);
      $view = $this->renderView(':admin:list_user.html.twig', ['users' => $users]);

      return new JsonResponse([
         'error' => null,
         'view' => $view
      ]);
   }

   /**
    * @param Request $request
    *
    * @Route(name="user_add", path="/user/add", options={"expose"=true})
    * @return JsonResponse
    */
   public function addUserAction(Request $request)
   {
      $error = null;
      $user = new User();

      $form = $this->createForm(UserType::class, $user);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
         $em = $this->get('doctrine.orm.entity_manager');
         $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
         $user->setPassword($password);
         $user->setEnabled(true);
         $em->persist($user);
         $em->flush();
      }
      else if($request->getMethod() == 'POST'){
            $error = 'Le formulaire est invalide';
      }
      $view = $this->renderView(':admin:add_user.html.twig', ['form' => $form->createView()]);
      return new JsonResponse([
         'view' => $view,
         'error' => $error,
         'user' => $user,
      ]);
      //return $this->render(':admin:add_user.html.twig', ['form' => $form->createView(), 'error' => $form->getErrors()]);

   }
}
