<?php

namespace Ant\LeagueBundle\Model;

/**
 * @author pc
 */
abstract class Match implements MatchInterface {

	protected $id;

	protected $publicatedAt;

	protected $createdBy;
	
	protected $local;
	
	protected $visitor;
	
	protected $gf;
	
	protected $ga;
	
	public function __construct()
	{
		$this->publicatedAt = new \DateTime('now');
	}
	
	public function __toString()
	{
		return $this->id;	
	}
	
	public function getPublicatedAt()
	{
		return $this->publicatedAt;
	}
}