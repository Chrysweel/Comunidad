<?php


namespace Ant\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Ant\LeagueBundle\Model\Community as BaseCommunity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use JMS\Serializer\Annotation\MaxDepth;

/**
 * @author pc
 * @ORM\Entity
 * @ORM\Table(name="league_community")
 * @UniqueEntity("name")
 */
class Community extends BaseCommunity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $name;
	
	/**
     * @ORM\ManyToMany(targetEntity="Ant\UserBundle\Entity\User", mappedBy="communities")
     **/
    protected $participants;
	
	
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $password;
	
	/**
     * @ORM\ManyToOne(targetEntity="Ant\UserBundle\Entity\User", inversedBy="ownCommunities")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     **/
	protected $owner;
	
	/**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="communities")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
	protected $game;
	
	/**
	 * @ORM\OneToMany(targetEntity="Match", mappedBy="community")
	 **/
	protected $matches;

	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matches = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Community
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
     * Set password
     *
     * @param string $password
     * @return Community
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add participants
     *
     * @param \Ant\UserBundle\Entity\User $participants
     * @return Community
     */
    public function addParticipant(\Ant\UserBundle\Entity\User $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \Ant\UserBundle\Entity\User $participants
     */
    public function removeParticipant(\Ant\UserBundle\Entity\User $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set owner
     *
     * @param \Ant\UserBundle\Entity\User $owner
     * @return Community
     */
    public function setOwner(\Ant\UserBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;
		
        $this->addParticipant($owner);
        $owner->addCommunity($this);
		
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Ant\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set game
     *
     * @param \Ant\LeagueBundle\Entity\Game $game
     * @return Community
     */
    public function setGame(\Ant\LeagueBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \Ant\LeagueBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Add matches
     *
     * @param \Ant\LeagueBundle\Entity\Match $matches
     * @return Community
     */
    public function addMatch(\Ant\LeagueBundle\Entity\Match $matches)
    {
        $this->matches[] = $matches;

        return $this;
    }

    /**
     * Remove matches
     *
     * @param \Ant\LeagueBundle\Entity\Match $matches
     */
    public function removeMatch(\Ant\LeagueBundle\Entity\Match $matches)
    {
        $this->matches->removeElement($matches);
    }

    /**
     * Get matches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatches()
    {
        return $this->matches;
    }
}
