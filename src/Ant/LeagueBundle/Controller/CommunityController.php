<?php

namespace Ant\LeagueBundle\Controller;

use Ant\LeagueBundle\Entity\Community;
use Ant\LeagueBundle\Form\CommunityType;
use Ant\UserBundle\Entity\User;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CommunityController extends BaseController
{
	/**
	 * @ApiDoc(
	 *  description="Create a new Community",
	 *  input="Ant\LeagueBundle\Form\CommunityType",
	 *  output="Ant\LeagueBundle\Entity\Community",
	 *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="community"    
	 * )
	 */
    public function postCommunitiesAction(Request $request)
    {
    	$community = new Community();
    	$form = $this->createForm(new CommunityType(), $community);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isValid()) {
    		$entity = $form->getData();
    		// perform some action, such as saving the task to the database
    		$this->getCommunityManager()->save($entity);
    		
    		return $this->buildResourceView($entity, 201, null);
    	}else{
    		return $this->buildFormErrorsView($form);
    	}
    	 return $this->handleView($view);
    }
    
    /**
     * @ApiDoc(
     *  description="Get Community",
	 *  output="Ant\LeageBundle\Entity\Community",
	 *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="community"
	 * )
     */
    public function getCommunityAction($id)
    {
    	$community = $this->get('ant.manager.community')->get($id);
    	
    	return $this->buildResourceView($community, 200, null);   
    }
    
    /**
     * @ApiDoc(
     *  description="Get Community",
     *  output="Ant\LeageBundle\Entity\Community",
     *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="community"
     * )
     */
    public function getCommunitiesAction()
    {
    	$communities = $this->get('ant.manager.community')->all();
    	 
    	return $this->buildResourceView($communities, 200, null);
    }
    /**
     * @ApiDoc(
     *  description="Delete Community",
     *  output="Ant\LeageBundle\Entity\Community",
     *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="community"
     * )
     * @ParamConverter("community", class="LeagueBundle:Community")
     */
    public function deleteCommunitiesAction(Community $community)
    {
    	$this->get('ant.manager.community')->delete($community);
    
    	return $this->buildResourceView('community deleted succesfully', 200, null);
    }
    
    /**
     * @ApiDoc(
     *  description="Get Communities of an user",
     *  output="Ant\LeageBundle\Entity\Community",
     *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="community"
     * )
     * @ParamConverter("user", class="UserBundle:User")
     */
    public function getUsersCommunitiesAction(User $user)
    {
    	$communities = $user->getCommunities();
    
    	return $this->buildResourceView($communities, 200, null);
    }
    
    
    
    public function patchCommunitiesAction()
    {
    	
    }
    
    public function putCommunitiesAction()
    {
    	
    }
    
    private function getCommunityManager()
    {
    	return $this->get('ant.manager.community');
    }

}
