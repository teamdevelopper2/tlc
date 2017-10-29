<?php

namespace Tlc\InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Tlc\InventoryBundle\Entity\OrderSale;
use Tlc\InventoryBundle\Form\OrderSaleType;

/**
 * OrderSale controller.
 *
 * @Route("ordersale")
 */
class OrderSaleController extends Controller
{
   /**
    * Affiche le formulaire de commande
    *
    * @Route("/", name="ordersale_index", options={"expose"= true})
    * @Method("GET")
    */
   public function indexAction()
   {
      $form = $this->createForm(OrderSaleType::class, new OrderSale())->createView();

      $ordersales = $this->getDoctrine()->getRepository('InventoryBundle:OrderSale')->findAll();

      return $this->render('ordersale/index.html.twig', ['ordersales' => $ordersales, 'form' => $form]);
   }


   /**
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\Response
    *
    * @Route(name="ordersale_new")
    */
   public function newAction(Request $request)
   {
      $orderSale = new OrderSale();
      $form = $this->createForm(OrderSaleType::class, $orderSale);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($orderSale);
         $em->flush();

         return $this->redirectToRoute('ordersale_details', array('id' => $orderSale->getId()));
      }
      return $this->forward('InventoryBundle:OrderSale:index');
   }

   /**
    * Finds and displays a product entity.
    *
    * @Route("/{id}", name="ordersale_details")
    * @Method("GET")
    * @param OrderSale $orderSale
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function showAction(OrderSale $orderSale)
   {
//      $deleteForm = $this->createDeleteForm($orderSale);

      return $this->render('order/details.html.twig', array('ordersale' => $orderSale));
   }

}
