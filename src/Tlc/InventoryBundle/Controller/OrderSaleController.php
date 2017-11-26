<?php

namespace Tlc\InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Tlc\InventoryBundle\Entity\OrderSale;
use Tlc\InventoryBundle\Entity\OrderSaleProduct;
use Tlc\InventoryBundle\Form\OrderSaleProductType;
use Tlc\InventoryBundle\Form\OrderSaleProductype;
use Tlc\InventoryBundle\Form\OrderSaleType;

/**
 * OrderSale controller.
 *
 */
class OrderSaleController extends Controller
{
    /**
     * Affiche le formulaire de commande ainsi que la liste des commande non validées
     *
     * @Route("/", name="ordersale_index", options={"expose"= true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $form = $this->createForm(OrderSaleType::class, new OrderSale())->createView();

        $ordersales = $this->getDoctrine()->getRepository('InventoryBundle:OrderSale')->findBy(['status' => false]);

        return $this->render('ordersale/index.html.twig', ['ordersales' => $ordersales, 'form' => $form]);
    }


    /**
     * Création d'une commande d'achat
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/new", name="ordersale_new")
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
     * Ajoute une ligne de commande d'achat
     * @param Request $request
     * @param OrderSale $orderSale
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/addProduct/{id}", name="ordersale_saleproduct")
     */
    public function saleProductAction(Request $request, OrderSale $orderSale)
    {
        $orderSaleProduct = new OrderSaleProduct();
        $form = $this->createForm(OrderSaleProductType::class, $orderSaleProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $orderSaleProduct->setOrderSale($orderSale);
            $em->persist($orderSaleProduct);
            $em->flush();
            return $this->redirectToRoute('ordersale_details', array('id' => $orderSaleProduct->getOrderSale()->getId()));
        }
        return $this->forward('InventoryBundle:OrderSale:show', ['orderSale' => $orderSale]);
    }
    /**
     * Récupère la liste des commandes validées
     *
     * @Route(path="/list-valid-command", name="ordersale_list_valid_command" )
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listValidCommandAction(Request $request)
    {
        $ordersales = $this->getDoctrine()
            ->getRepository('InventoryBundle:OrderSale')
            ->findBy(['status' => true]);

        return $this->render('order/list-valid-command.html.twig', ['ordersales' => $ordersales]);
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
        $form = $this->createForm(OrderSaleProductType::class, new OrderSaleProduct())->createView();
        $commande = $this->getDoctrine()
            ->getRepository('InventoryBundle:OrderSaleProduct')
            ->findBy(['orderSale' => $orderSale]);

        return $this->render('order/details.html.twig', [
            'ordersale' => $orderSale,
            'form' => $form,
            'commande' => $commande]);
    }

    /**
     * @Route("/valid-command/{id}", name="ordersale_validate_command")
     * @Method("GET")
     * @param OrderSale $orderSale
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validCommandeAction(OrderSale $orderSale)
    {
        if(!$orderSale->getStatus()){
            $orderSale->setStatus(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderSale);
            $em->flush();
        }

        return $this->render('order/factureSale.html.twig', ['ordersale' => $orderSale]);
    }



}
