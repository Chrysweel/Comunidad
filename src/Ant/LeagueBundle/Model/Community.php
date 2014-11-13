<?php

namespace Ant\LeagueBundle\Model;

/**
 * @author pc
 */
abstract class Community implements CommunityInterface {

	protected $id;

	protected $publicatedAt;
	
	protected $owner;
	
	protected $name;
	
	protected $participants;
	
	protected $password;

	public function __construct()
	{
		$this->publicatedAt = new \DateTime('now');
	}
	
	
	public function __toString()
	{
		return $this->name;
	}
	
	public function getPublicatedAt()
	{
		return $this->publicatedAt;
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function setPublicatedAt($publicatedAt) {
		$this->publicatedAt = $publicatedAt;
		return $this;
	}
	public function getOwner() {
		return $this->owner;
	}
	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}
	
}
