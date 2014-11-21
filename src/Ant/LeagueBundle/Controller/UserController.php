<?php


namespace Ant\LeagueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author pc
 */
class UserController extends Controller
{
	
	/**
     * @ApiDoc(
     *  description="Get Users",
     *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="users"
     * )
     */
    public function getUsersAction()
    {
    	$users = $this->getUserManager->findUsers();
    	 
    	return $this->buildResourceView($users, 200, null);
    }
    
    protected function getUserManager()
    {
    	return $this->container->get('fos_user.user_manager');
    }
}