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
	
	
	//Principio de las estadísticas
	//@TODO mover esto para un manager/servicio exclusivo de estadisticas o utilizar el repositorio
	
	/**
	 * Get match with more goals for
	 * @param integer $idCommunity
	 */
	public function getMaxGFOfCommunity($idCommunity)
	{
		$query = $this->em->createQuery(
				'SELECT m
		    FROM LeagueBundle:Match m
			WHERE m.community = :id
			AND m.gf = (SELECT MAX(m2.gf) FROM  LeagueBundle:Match m2)
		    ')->setParameter('id', $idCommunity);
		
		return $query->getResult();
	}
	
	/**
	 * Get match with more goals against
	 * @param integer $idCommunity
	 */
	public function getMaxGAOfCommunity($idCommunity)
	{
		$query = $this->em->createQuery(
				'SELECT m
		    FROM LeagueBundle:Match m
			WHERE m.community = :id
			AND m.ga = (SELECT MAX(m2.ga) FROM  LeagueBundle:Match m2)
		    ')->setParameter('id', $idCommunity);
	
		return $query->getResult();
	}
	
	/**
	 * Get avg of goals favour to user as local.
	 * @param integer $idCommunity
	 * @param integer $idUserLocal
	 * Return: array (num_matches, avg_gf)
	 */
	public function getAvgGfOfUserLocal($idCommunity, $idUserLocal)
	{
		$query = $this->em->createQuery(
			'SELECT COUNT(m.id) , Avg(m.gf)
		    FROM LeagueBundle:Match m
			WHERE m.community = :id
			AND m.local = :idUserLocal
		    ')->setParameters(array(
		    		'id' => $idCommunity,
		    		'idUserLocal' => $idUserLocal
		    ));
		return $query->getResult();
	}
	
	/**
	 * Get avg of goals against to user as visitor. ( Es decir los goles que ha marcado un usuario como jugador visitante )
	 * @param integer $idCommunity
	 * @param integer $idUserLocal
	 * Return: array (num_matches, avg_gf)
	 */
	public function getAvgGfOfUserVisitor($idCommunity, $idUserVisitor)
	{
		$query = $this->em->createQuery(
			'SELECT COUNT(m.id) , Avg(m.ga)
		    FROM LeagueBundle:Match m
			WHERE m.community = :id
			AND m.visitor = :idUserVisitor
		    ')->setParameters(array(
		    		'id' => $idCommunity,
		    		'idUserVisitor' => $idUserVisitor
		    ));
		    return $query->getResult();
	}
	
	/**
	 * 
	 * @param integer $idCommunity
	 * @param integer $idUser
	 * @return number ( media de goles marcados tanto de jugador local como de jugador visitante)
	 */
	public function getAvgGoalsOfUser($idCommunity, $idUser)
	{
		
		//get num matches and sum goals as play local
		$queryGA = $this->em->createQuery(
			'SELECT COUNT(m.id) AS numMatchs, SUM(m.ga) AS totalGoals
		    FROM LeagueBundle:Match m
			WHERE m.community = :id
			AND m.visitor = :idUserVisitor
		    ')->setParameters(array(
			    		'id' => $idCommunity,
			    		'idUserVisitor' => $idUser
			    ));
		$resultQueryGA = $queryGA->getOneOrNullResult();
		
		//get num matches and sum goals as play visitor
	    $queryGF = $this->em->createQuery(
    		'SELECT COUNT(m.id) AS numMatchs, SUM(m.gf) AS totalGoals
		    FROM LeagueBundle:Match m
			WHERE m.community = :id
			AND m.local = :idUser
		    ')->setParameters(array(
		    		    		'id' => $idCommunity,
		    		    		'idUser' => $idUser
		    		    ));
		    
		$resultQueryGF = $queryGF->getOneOrNullResult();
		
		//calculate the avg the num matchs total and sum goals
		$AVGGoalsFavour = ($resultQueryGA['totalGoals']+$resultQueryGF['totalGoals'])/($resultQueryGA['numMatchs']+$resultQueryGF['numMatchs']);
		
		return $AVGGoalsFavour;
	}
	
	public function getStatistics($idCommunity)
	{
		$maxGA = $this->getMaxGAOfCommunity($idCommunity);
		$maxGF = $this->getMaxGFOfCommunity($idCommunity);
		$statistics = array();
		//1 es el usuario al que le cogemos las estadísticas
		//Hay que hacer las estadisticas para toda la comunidad
		array_push($statistics, ['AvgGFWithLocal' => $this->getAvgGfOfUserLocal($idCommunity, 1)]);
		array_push($statistics, ['AvgGAWithVisitor' => $this->getAvgGfOfUserVisitor($idCommunity, 1)]);
		array_push($statistics, ['AvgGoalsOfUser' => $this->getAvgGoalsOfUser($idCommunity, 1)]);
		
		array_push($statistics, ['maxGA' => $maxGA]);
		array_push($statistics, ['maxGF' => $maxGF]);
		
		return $statistics;
		
		
	}
	//FINAL de las estadísticas
	
	
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