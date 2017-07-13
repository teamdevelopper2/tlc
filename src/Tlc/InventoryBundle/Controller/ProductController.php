<?php

namespace Tlc\InventoryBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tlc\InventoryBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Tlc\InventoryBundle\Form\ProductType;
/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index", options={"expose"= true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('InventoryBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

   /**
    * Finds and displays a product entity.
    *
    * @Route("/{id}", name="product_show")
    * @Method("GET")
    * @param Product $product
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route(name="product_edit", path="/{id}/edit", options={"expose" = true})
     * @return JsonResponse
     */
    public function editAction(Request $request, $id)
    {
//        $deleteForm = $this->createDeleteForm($product);
        $error = null;
        try {
                $product = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('InventoryBundle:Product')
                                ->find($id);
                $form = $this->createForm('Tlc\InventoryBundle\Form\ProductType', $product);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $product->setUpdatedAt(new \DateTime());
                    $this->getDoctrine()
                        ->getManager()
                        ->flush();

//                    return $this->redirectToRoute('product_index');
                    return new JsonResponse([
                        'ulrToRedirect' => 'product_index',
                        'error' => null
                    ]);
                }
                elseif ($request->getMethod() == "POST") {
                    $error = "Formulaire non valide !!!";
                    return new JsonResponse([
                        'error' => $error,
                    ]);
                }
                $view = $this->renderView(':product:edit.html.twig', ['form' => $form->createView()]);
        }catch (\Exception $exception) {
            var_dump($exception->getMessage() . 'et fichier' . $exception->getFile());
            $error = $exception->getMessage();
        }

        return new JsonResponse([
            'view' => $view,
            'error' => $error,
            'id' => $id
        ]);
//        return $this->render('product/edit.html.twig', array(
//            'product' => $product,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     * * @param Request $request
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
