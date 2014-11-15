<?php

namespace Ant\LeagueBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ant\LeagueBundle\Entity\Match;
use Ant\LeagueBundle\Form\MatchType;

use Symfony\Component\HttpFoundation\Request;

class MatchController extends BaseController
{
	
	/**
	 * @ApiDoc(
	 *  description="Create a new match",
	 *  input="Ant\LeagueBundle\Form\MatchType",
	 *  statusCodes={
	 *         201="Returned when successful",
	 *         403="Returned when the user is not authorized to say hello",
	 *         404={
	 *           "Returned when the user is not found",
	 *           "Returned when something else is not found"
	 *         }
	 *     },
	 * section="match"
	 * )
	 */
	public function postMatchAction(Request $request)
	{
		$match = new Match();
		$form = $this->createForm(new MatchType(), $match);
		 
		$form->handleRequest($request);
		 
		if ($form->isValid()) {
			$entity = $form->getData();
			// perform some action, such as saving the task to the database
			$this->getMatchManager()->save($entity);
			//hacemos esto porque al guardar un partido, guardamos en la comunidad sus participantes
			//no quier hacer evento, ni inyectar el manager
			$this->getCommunityManager()->save($entity->getCommunity());
			return $this->buildResourceView($entity, 201, null);
		}else{
			return $this->buildFormErrorsView($form);
		}
	}
	
	public function deleteMatchAction()
	{
		
	}
	
	private function getMatchManager()
	{
		return $this->get('ant.manager.match');
	}
	
	private function getCommunityManager()
	{
		return $this->get('ant.manager.community');
	}
}
