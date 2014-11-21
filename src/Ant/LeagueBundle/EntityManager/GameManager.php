<?php

namespace Ant\LeagueBundle\EntityManager;

use Ant\LeagueBundle\ModelManager\GameManager as BaseGameManager;
use Doctrine\ORM\EntityManager;

class GameManager extends BaseGameManager
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
	
	public function get($id)
	{
		return $this->repository->findOneById($id);
	}
	
	public function findAll()
	{
		return $this->repository->findAll();
	}

	public function doSave($entity)
	{
		$this->em->persist($entity);
		$this->em->flush();
	}
}