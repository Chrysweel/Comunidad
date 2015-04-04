<?php


namespace Ant\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Ant\LeagueBundle\Model\Game as BaseGame;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use JMS\Serializer\Annotation\MaxDepth;

/**
 * @author pc
 * @ORM\Entity
 * @ORM\Table(name="league_game")
 * @UniqueEntity("name")
 */
class Game extends BaseGame
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numberPlayers;
		
	/**
	 * @ORM\Column(type="string" , nullable=true)
	 * @var string
     * @Assert\Null()
	 */
	protected $website;
	
	/**
	 * @ORM\OneToMany(targetEntity="Community", mappedBy="game")
	 * @MaxDepth(1)
	 */
	protected $communities;
	
	
	public function __construct()
	{
		$this->communities = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->name;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set numberPlayers
     *
     * @param integer $numberPlayers
     * @return Game
     */
    public function setNumberPlayers($numberPlayers)
    {
        $this->numberPlayers = $numberPlayers;

        return $this;
    }

    /**
     * Get numberPlayers
     *
     * @return integer 
     */
    public function getNumberPlayers()
    {
        return $this->numberPlayers;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Game
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Add communities
     *
     * @param \Ant\LeagueBundle\Entity\Community $communities
     * @return Game
     */
    public function addCommunity(\Ant\LeagueBundle\Entity\Community $communities)
    {
        $this->communities[] = $communities;

        return $this;
    }

    /**
     * Remove communities
     *
     * @param \Ant\LeagueBundle\Entity\Community $communities
     */
    public function removeCommunity(\Ant\LeagueBundle\Entity\Community $communities)
    {
        $this->communities->removeElement($communities);
    }

    /**
     * Get communities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommunities()
    {
        return $this->communities;
    }
}
