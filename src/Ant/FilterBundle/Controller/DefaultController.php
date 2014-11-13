<?php

namespace Ant\FilterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FilterBundle:Default:index.html.twig', array('name' => $name));
    }
}
