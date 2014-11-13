<?php

namespace Ant\LeagueBundle\Model;

/**
 * @author pc
 */
abstract class Game implements GameInterface
{

	protected $id;

	protected $name;
	
	protected $numberPlayers;
	
	protected $website;
	
	protected $communities;
}