<?php

namespace Tlc\InventoryBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tlc\InventoryBundle\Entity\OrderPurchase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Tlc\InventoryBundle\Entity\OrderPurchaseProduct;
use Tlc\InventoryBundle\Entity\Product;
use Tlc\InventoryBundle\Form\OrderPurchaseProductType;
use Tlc\InventoryBundle\Repository\OrderPurchaseProductRepository;

/**
 * Orderpurchase controller.
 *
 * @Route("orderpurchase")
 */
class OrderPurchaseController extends Controller
{
   /**
    * Lists all orderPurchase entities.
    *
    * @Route("/", name="orderpurchase_index")
    * @Method("GET")
    */
   public function indexAction()
   {
      $em = $this->getDoctrine()->getManager();

      $orderPurchases = $em->getRepository('InventoryBundle:OrderPurchase')->findAll();
      $orderPurchase = new Orderpurchase();
      $form = $this->createForm('Tlc\InventoryBundle\Form\OrderPurchaseType', $orderPurchase);

      return $this->render('orderpurchase/index.html.twig', array(
         'orderPurchases' => $orderPurchases,
         'form' => $form->createView()
      ));
   }


   /**
    * Creates a new orderPurchase entity.
    *
    * @Route("/new", name="orderpurchase_new")
    * @Method({"GET", "POST"})
    */
   public function newAction(Request $request)
   {
      $orderPurchase = new Orderpurchase();
      $form = $this->createForm('Tlc\InventoryBundle\Form\OrderPurchaseType', $orderPurchase);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($orderPurchase);
         $em->flush();

         return $this->redirectToRoute('orderpurchase_show', array('id' => $orderPurchase->getId()));
      }

      return $this->render('orderpurchase/new.html.twig', array(
         'orderPurchase' => $orderPurchase,
         'form' => $form->createView(),
      ));
   }

   private function findProduct($id)
   {
      return $this->getDoctrine()
         ->getManager()
         ->getRepository('InventoryBundle:Product')
         ->find($id);
   }

   private function findOrderPurchase($id)
   {
      return $this->getDoctrine()
         ->getManager()
         ->getRepository('InventoryBundle:OrderPurchase')
         ->find($id);
   }
   /**
    * @Route("/addProduit/{id}", name="orderPurchase_purchaseproduct")
    */
   public function purchaseProduitAction(Request $request, OrderPurchase $orderPurchaser)
   {
      $orderPurchaseproduct = new OrderPurchaseProduct();
      $form = $this->createForm('Tlc\InventoryBundle\Form\OrderPurchaseProductType', $orderPurchaseproduct);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $orderPurchaseproduct->setOrderpurchase($orderPurchaser);
         $em->persist($orderPurchaseproduct);
         $em->flush();
         return $this->redirectToRoute('orderpurchase_show', ['id' => $orderPurchaseproduct->getOrderpurchase()->getId()]);
      }
      return $this->forward('InventoryBundle:OrderPurchase:show', ['orderPurchase' => $orderPurchaser]);
   }

   /**
    * @param Request $request
    * @param $idProd
    * @param $idOrd
    * @Route("/{idProd}/{idOrd}", name="edit_orderpurchaseproduct",  options={"expose" = true})
    * @Method({"GET","POST"})
    * @return JsonResponse
    */
   public function editPurchaseProduct(Request $request, $idProd, $idOrd)
   {
      $product = $this->findProduct($idProd);
      $orderpurchase = $this->findOrderPurchase($idOrd);
      $orderPurchaseProduct = null;
      if ($product != null && $orderpurchase != null) {
         $orderPurchaseProduct = $this->getDoctrine()
            ->getRepository('InventoryBundle:OrderPurchaseProduct')
            ->findOrderPuchaseProduct($product, $orderpurchase);
      }
      $editForm = $this->createForm(OrderPurchaseProductType::class, $orderPurchaseProduct);
      $editForm->handleRequest($request);
      $error = null;
      if ($editForm->isSubmitted() && $editForm->isValid()) {
         $this->getDoctrine()->getManager()->flush();
         // return $this->redirectToRoute('orderpurchase_show', ['id' => $orderPurchaseProduct->getOrderpurchase()->getId()]);
      }
      $view = $this->renderView('orderpurchase/edit_order-purchase_product.html.twig', ['form' => $editForm->createView()]);

      return new JsonResponse([
         'view' => $view,
         'error' => $error,
         'orderPurchProd' => $orderPurchaseProduct
      ]);

   }

   /**
    * Finds and displays a orderPurchase entity.
    *
    * @Route("/{id}", name="orderpurchase_show")
    * @Method("GET")
    */
   public function showAction(OrderPurchase $orderPurchase)
   {
      $from = $this->createForm(OrderPurchaseProductType::class, new OrderPurchaseProduct());
      $cmd_achat = $this->getDoctrine()
         ->getRepository('InventoryBundle:OrderPurchaseProduct')
         ->findBy(array('orderpurchase' => $orderPurchase));
      return $this->render('orderpurchase/detail_purchase.html.twig', [
         'form' => $from->createView(),
         'orderPurchase' => $orderPurchase,
         'cmdAchat' => $cmd_achat
      ]);
   }




   /**
    * Displays a form to edit an existing orderPurchase entity.
    *
    * @Route("/{id}/edit", name="orderpurchase_edit")
    * @Method({"GET", "POST"})
    */
   public function editAction(Request $request, OrderPurchase $orderPurchase)
   {
      $deleteForm = $this->createDeleteForm($orderPurchase);
      $editForm = $this->createForm('Tlc\InventoryBundle\Form\OrderPurchaseType', $orderPurchase);
      $editForm->handleRequest($request);

      if ($editForm->isSubmitted() && $editForm->isValid()) {
         $this->getDoctrine()->getManager()->flush();

         return $this->redirectToRoute('orderpurchase_edit', array('id' => $orderPurchase->getId()));
      }

      return $this->render('orderpurchase/edit.html.twig', array(
         'orderPurchase' => $orderPurchase,
         'edit_form' => $editForm->createView(),
         'delete_form' => $deleteForm->createView(),
      ));
   }

   /**
    * Deletes a orderPurchase entity.
    *
    * @Route("/{id}", name="orderpurchase_delete")
    * @Method("DELETE")
    */
   public function deleteAction(Request $request, OrderPurchase $orderPurchase)
   {
      $form = $this->createDeleteForm($orderPurchase);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->remove($orderPurchase);
         $em->flush();
      }

      return $this->redirectToRoute('orderpurchase_index');
   }

   /**
    * Creates a form to delete a orderPurchase entity.
    *
    * @param OrderPurchase $orderPurchase The orderPurchase entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
   private function createDeleteForm(OrderPurchase $orderPurchase)
   {
      return $this->createFormBuilder()
         ->setAction($this->generateUrl('orderpurchase_delete', array('id' => $orderPurchase->getId())))
         ->setMethod('DELETE')
         ->getForm();
   }
}
