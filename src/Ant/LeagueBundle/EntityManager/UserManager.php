<?php

namespace Ant\LeagueBundle\EntityManager;

use Ant\LeagueBundle\ModelManager\GameManager as BaseGameManager;
use Doctrine\ORM\EntityManager;

class UserManager extends BaseUserManager
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

	public function doSave($entity)
	{
		$this->em->persist($entity);
		$this->em->flush();
	}
}