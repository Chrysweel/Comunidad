<?php

namespace Ant\LeagueBundle\ModelManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

use Ant\LeagueBundle\Entity\Community;


abstract class CommunityManager
{
	protected $eventDispatcher;
	
	public function __construct(EventDispatcherInterface $eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;

	}
	
	public function save(Community $community)
	{
		return $this->doSave($community);
	}
	
	public function all()
	{
		return $this->doAll();
	}
	
	public function delete($community)
	{
		return $this->doDelete($community);
	}
	
	public function addParticipant($community, AdvancedUserInterface $user)
	{
		$community->addParticipant($user);
		$this->save($community);
	}
}