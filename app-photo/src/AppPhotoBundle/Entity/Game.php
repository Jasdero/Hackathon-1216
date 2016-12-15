<?php

namespace AppPhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppPhotoBundle\Repository\GameRepository")
 */
class Game
{
	/**
	 * One Game has One Leader.
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="leadedGames")
	 * @ORM\JoinColumn(name="leader_id", referencedColumnName="id")
	 */
	private $leader;

	/**
	 * Many Game has Many playing Users.
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="playedGames")
	 */
	private $players;

	/**
	 * One Game has One To guess Image.
	 * @ORM\OneToOne(targetEntity="Image")
	 * @ORM\JoinColumn(name="to_guess_image_id", referencedColumnName="id")
	 */
	private $toGuessImage;

	/**
	 * One Game has Many GameAnswer.
	 * @ORM\OneToMany(targetEntity="GameAnswer", mappedBy="game", cascade={"remove"})
	 */
	private $propositions;

	////////////////////
	// Generated code //
	////////////////////

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * Constructor
     */
    public function __construct()
    {
        $this->propositions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set leader
     *
     * @param \AppPhotoBundle\Entity\User $leader
     *
     * @return Game
     */
    public function setLeader(\AppPhotoBundle\Entity\User $leader = null)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * Get leader
     *
     * @return \AppPhotoBundle\Entity\User
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Set toGuessImage
     *
     * @param \AppPhotoBundle\Entity\Image $toGuessImage
     *
     * @return Game
     */
    public function setToGuessImage(\AppPhotoBundle\Entity\Image $toGuessImage = null)
    {
        $this->toGuessImage = $toGuessImage;

        return $this;
    }

    /**
     * Get toGuessImage
     *
     * @return \AppPhotoBundle\Entity\Image
     */
    public function getToGuessImage()
    {
        return $this->toGuessImage;
    }

    /**
     * Add proposition
     *
     * @param \AppPhotoBundle\Entity\GameAnswer $proposition
     *
     * @return Game
     */
    public function addProposition(\AppPhotoBundle\Entity\GameAnswer $proposition)
    {
        $this->propositions[] = $proposition;

        return $this;
    }

    /**
     * Remove proposition
     *
     * @param \AppPhotoBundle\Entity\GameAnswer $proposition
     */
    public function removeProposition(\AppPhotoBundle\Entity\GameAnswer $proposition)
    {
        $this->propositions->removeElement($proposition);
    }

    /**
     * Get propositions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * Add player
     *
     * @param \AppPhotoBundle\Entity\User $player
     *
     * @return Game
     */
    public function addPlayer(\AppPhotoBundle\Entity\User $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \AppPhotoBundle\Entity\User $player
     */
    public function removePlayer(\AppPhotoBundle\Entity\User $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
