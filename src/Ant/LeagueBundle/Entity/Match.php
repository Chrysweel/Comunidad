<?php


namespace Ant\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Ant\LeagueBundle\Model\Match as BaseMatch;

use JMS\Serializer\Annotation\Type;

use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation\MaxDepth;

/**
 * @author pc
 * @ORM\Entity
 * @ORM\Table(name="league_match")
 */
class Match extends BaseMatch
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Type("DateTime<'Y-m-d H:i:s'>")
	 * @Assert\Date
	 */
	protected $publicatedAt;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Ant\UserBundle\Entity\User", inversedBy="matches")
	 * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", onDelete="CASCADE")
	 * @MaxDepth(2)
	 */
	protected $createdBy;
	
	/**
     * @ORM\ManyToOne(targetEntity="Ant\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="local_id", referencedColumnName="id")
     * @MaxDepth(2)
     **/
	protected $local;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Ant\UserBundle\Entity\User")
	 * @ORM\JoinColumn(name="visitor_id", referencedColumnName="id")
	 * @MaxDepth(2)
	 **/
	protected $visitor;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $gf;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $ga;
	

	/**
	 * @ORM\ManyToOne(targetEntity="Community", inversedBy="matches")
	 * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
	 * @MaxDepth(1)
	 **/
	protected $community;
	
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
     * Set publicatedAt
     *
     * @param \DateTime $publicatedAt
     * @return Match
     */
    public function setPublicatedAt($publicatedAt)
    {
        $this->publicatedAt = $publicatedAt;

        return $this;
    }

    /**
     * Get publicatedAt
     *
     * @return \DateTime 
     */
    public function getPublicatedAt()
    {
        return $this->publicatedAt;
    }

    /**
     * Set gf
     *
     * @param integer $gf
     * @return Match
     */
    public function setGf($gf)
    {
        $this->gf = $gf;

        return $this;
    }

    /**
     * Get gf
     *
     * @return integer 
     */
    public function getGf()
    {
        return $this->gf;
    }

    /**
     * Set ga
     *
     * @param integer $ga
     * @return Match
     */
    public function setGa($ga)
    {
        $this->ga = $ga;

        return $this;
    }

    /**
     * Get ga
     *
     * @return integer 
     */
    public function getGa()
    {
        return $this->ga;
    }

    /**
     * Set createdBy
     *
     * @param \Ant\UserBundle\Entity\User $createdBy
     * @return Match
     */
    public function setCreatedBy(\Ant\UserBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Ant\UserBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set local
     *
     * @param \Ant\UserBundle\Entity\User $local
     * @return Match
     */
    public function setLocal(\Ant\UserBundle\Entity\User $local = null)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return \Ant\UserBundle\Entity\User 
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set visitor
     *
     * @param \Ant\UserBundle\Entity\User $visitor
     * @return Match
     */
    public function setVisitor(\Ant\UserBundle\Entity\User $visitor = null)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return \Ant\UserBundle\Entity\User 
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Set community
     *
     * @param \Ant\LeagueBundle\Entity\Community $community
     * @return Match
     */
    public function setCommunity(\Ant\LeagueBundle\Entity\Community $community = null)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \Ant\LeagueBundle\Entity\Community 
     */
    public function getCommunity()
    {
        return $this->community;
    }
}
