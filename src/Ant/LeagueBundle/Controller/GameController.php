<?php

namespace Ant\LeagueBundle\Controller;

use Ant\LeagueBundle\Entity\Game;
use Ant\LeagueBundle\Form\GameType;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author pc
 */
class GameController extends BaseController
{
	
/**
	 * @ApiDoc(
	 *  description="Create a new Game",
	 *  input="Ant\LeagueBundle\Form\GameType",
	 *  output="Ant\LeagueBundle\Entity\Game",
	 *  statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     * section="games"
	 * )
	 */
    public function postGamesAction(Request $request)
    {
    	$game = new Game();
    	$form = $this->createForm(new GameType(), $game);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isValid()) {
    		$entity = $form->getData();
    		// perform some action, such as saving the task to the database
    		$this->getGameManager()->save($entity);
    		return $this->buildResourceView($entity, 201, null);
    	}else{
    		return $this->buildFormErrorsView($form);
    	}
    }
    
    
    
    
    private function getGameManager()
    {
    	return $this->get('ant.manager.game');
    }
}