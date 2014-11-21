<?php

namespace Ant\LeagueBundle\ModelManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Ant\LeagueBundle\Entity\Game;

abstract class GameManager
{
	protected $eventDispatcher;
	
	public function __construct(EventDispatcherInterface $eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;

	}
	public function save(Game $game)
	{
		return $this->doSave($game);
	}
	
	public function getAll()
	{
		return $this->findAll();
	}
}