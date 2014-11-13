<?php

namespace Ant\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->ownCommunities = new ArrayCollection();
        $this->communities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matches = new ArrayCollection();
    }
    
    /**
    * @ORM\ManyToMany(targetEntity="Ant\LeagueBundle\Entity\Community", inversedBy="users")
    * @ORM\JoinTable(name="users_communities")
    **/
    protected $communities;    
    
    /**
     * @ORM\OneToMany(targetEntity="Ant\LeagueBundle\Entity\Community", mappedBy="user")
     **/
    protected $ownCommunities;
    
    /**
     * @ORM\OneToMany(targetEntity="Ant\LeagueBundle\Entity\Match", mappedBy="createdBy")
     */
    protected $matches;
    
    /**
     * @var string
     * 
     */
    protected $username;
    
    /**
     * @var string
     */
    protected $usernameCanonical;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var string
     */
    protected $emailCanonical;
    
    /**
     * @var boolean
     */
    protected $enabled;
    
    /**
     * The salt to use for hashing
     *
     * @var string
     */
    protected $salt;
    
    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     */
    protected $password;
    
    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;
    
    /**
     * @var \DateTime
     */
    protected $lastLogin;
    
    /**
     * Random string sent to the user email address in order to verify it
     *
     * @var string
     */
    protected $confirmationToken;
    
    /**
     * @var \DateTime
     */
    protected $passwordRequestedAt;
    
    /**
     * @var Collection
     */
    protected $groups;
    
    /**
     * @var boolean
     */
    protected $locked;
    
    /**
     * @var boolean
     */
    protected $expired;
    
    /**
     * @var \DateTime
     */
    protected $expiresAt;
    
    /**
     * @var array
     */
    protected $roles;
    
    /**
     * @var boolean
     */
    protected $credentialsExpired;
    
    /**
     * @var \DateTime
     */
    protected $credentialsExpireAt;
    
    

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
     * Add communities
     *
     * @param \Ant\LeagueBundle\Entity\Community $communities
     * @return User
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

    /**
     * Add ownCommunities
     *
     * @param \Ant\LeagueBundle\Entity\Community $ownCommunities
     * @return User
     */
    public function addOwnCommunity(\Ant\LeagueBundle\Entity\Community $ownCommunities)
    {
        $this->ownCommunities[] = $ownCommunities;

        return $this;
    }

    /**
     * Remove ownCommunities
     *
     * @param \Ant\LeagueBundle\Entity\Community $ownCommunities
     */
    public function removeOwnCommunity(\Ant\LeagueBundle\Entity\Community $ownCommunities)
    {
        $this->ownCommunities->removeElement($ownCommunities);
    }

    /**
     * Get ownCommunities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnCommunities()
    {
        return $this->ownCommunities;
    }

    /**
     * Add matches
     *
     * @param \Ant\LeagueBundle\Entity\Match $matches
     * @return User
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
