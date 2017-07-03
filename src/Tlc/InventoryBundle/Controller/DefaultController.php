<?php

namespace Tlc\InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('InventoryBundle:Default:index.html.twig');
    }
}
