<?php


namespace Ant\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author pc
 */
class UserController extends Controller
{
	
    public function indexAction($name)
    {
        return $this->render('RecipeBundle:Default:index.html.twig', array('name' => $name));
    }
}