<?php

namespace Ant\LeagueBundle\ModelManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
		$this->manager->doSave($match);
	}
	
}