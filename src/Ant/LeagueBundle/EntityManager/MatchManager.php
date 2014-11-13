<?php

namespace Ant\LeagueBundle\EntityManager;

use Ant\LeagueBundle\Entity\Match;

use Doctrine\ORM\EntityManager;

class MatchManager
{	
	/**
	 * @var EntityManager
	 */
	protected $em;	
	
	protected $repository;
	
	public function __construct(EntityManager $em, $class)
	{
		$this->em = $em;
		$this->repository = $em->getRepository($class);
	}
	
	public function doSave(Match $match)
	{
		$this->em->persist($match);
		$this->em->flush();
	}

}