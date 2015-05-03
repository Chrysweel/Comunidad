<?php

namespace Ant\LeagueBundle\ModelManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MatchManager
{
	protected $eventDispatcher;
	
	protected $manager;
	
	public function __construct(EventDispatcherInterface $eventDispatcher, $manager)
	{
		$this->eventDispatcher = $eventDispatcher;
		$this->manager = $manager;

	}
	
	public function save($match)
	{
		if ($match->getCreatedBy() == $match->getCommunity()->getOwner()){
			$this->manager->doSave($match);
			
			$match->getCommunity()->addParticipant($match->getVisitor());
			$match->getCommunity()->addParticipant($match->getLocal());
			
		}else{
			throw new AccessDeniedHttpException('You must owner of community to register a match');
		}
		
	}
	
	public function delete($match)
	{
		return $this->manager->doDelete($match);
	}

	public function findMatchesByUser($user)
	{
		return $this->manager->doFindMatchesByUser($user);
	}
	
}