<?php

namespace Tlc\UserBundle\Controller;

use FOS\UserBundle\Model\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tlc\UserBundle\Entity\Profil;
use Tlc\UserBundle\Form\ProfilType;

class ProfilController extends Controller
{
   /**
    * @Route(name="profil_list", path="profil/list", options={"expose"=true})
    */
   public function listAction()
   {
      $profils = $this->getDoctrine()->getManager()
         ->getRepository('UserBundle:Profil')
         ->findAll();

      return new JsonResponse([
         'view' => $this->renderView(':admin/profil:list_profil.html.twig', ['profils' => $profils]),
         'error' => null
      ]);
   }

   /**
    * @param Request $request
    *
    * @Route(name="profil_add", path="/profil/add", options={"expose"=true})
    * @return JsonResponse
    */
   public function addProfilAction(Request $request)
   {
      $error = null;
      $profil = new Profil(User::ROLE_DEFAULT);
      $profil->setRole(null);

      $form = $this->createForm(ProfilType::class, $profil);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
         $em = $this->get('doctrine.orm.entity_manager');
         $em->persist($profil);
         $em->flush();
      }
      else if($request->getMethod() == 'POST'){
         $error = 'Le formulaire est invalide';
      }
      $view = $this->renderView(':admin/profil:add_profil.html.twig', ['form' => $form->createView()]);
      return new JsonResponse([
         'view' => $view,
         'error' => $error,
         'profil' => $profil,
      ]);

   }

}
