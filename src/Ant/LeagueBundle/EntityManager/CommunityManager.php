<?php

namespace Ant\LeagueBundle\EntityManager;

use Ant\LeagueBundle\ModelManager\CommunityManager as BaseCommunityManager;
use Ant\LeagueBundle\Entity\Community;

use Doctrine\ORM\EntityManager;

use Ant\FilterBundle\ModelManager\FilterableManager;

class CommunityManager extends BaseCommunityManager
{	
	/**
	 * @var EntityManager
	 */
	protected $em;	
	
	protected $repository;
	
	protected $filterable_manager;
	
	public function __construct(EntityManager $em, $class, FilterableManager $filterable_manager)
	{
		$this->em = $em;
		$this->repository = $em->getRepository($class);
		$this->filterable_manager = $filterable_manager;
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
	
	public function doAll()
	{
		return $this->repository->findAll();
	}
	
	public function doDelete(Community $community)
	{
		$this->em->remove($community);
		$this->em->flush();
	}
	
	
	

}