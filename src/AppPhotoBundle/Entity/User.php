<?php
// src/AppPhotoBundle/Entity/User.php

namespace AppPhotoBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
	public function __toString() {
		return $this->username;
	}
	/**
	 * One User has Many Games he leads.
	 * @ORM\OneToMany(targetEntity="Game", mappedBy="leader", cascade={"remove"})
	 */
	private $leadedGames;

	/**
	 * Many Users have Many played games.
	 * @ORM\ManyToMany(targetEntity="Game", inversedBy="players")
	 * @ORM\JoinTable(name="users_games")
	 */
	private $playedGames;

	/**
	 * One User has Many GameAnswer.
	 * @ORM\OneToMany(targetEntity="GameAnswer", mappedBy="user")
	 */
	private $propositions;

    /**
     * @var integer
     * @ORM\Column(name= "score", type="integer")
     */

	private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

	////////////////////
	// Generated code //
	////////////////////

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->score = 0;
    }

    /**
     * Add leadedGame
     *
     * @param \AppPhotoBundle\Entity\Game $leadedGame
     *
     * @return User
     */
    public function addLeadedGame(\AppPhotoBundle\Entity\Game $leadedGame)
    {
        $this->leadedGames[] = $leadedGame;

        return $this;
    }

    /**
     * Remove leadedGame
     *
     * @param \AppPhotoBundle\Entity\Game $leadedGame
     */
    public function removeLeadedGame(\AppPhotoBundle\Entity\Game $leadedGame)
    {
        $this->leadedGames->removeElement($leadedGame);
    }

    /**
     * Get leadedGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeadedGames()
    {
        return $this->leadedGames;
    }

    /**
     * Add playedGame
     *
     * @param \AppPhotoBundle\Entity\Game $playedGame
     *
     * @return User
     */
    public function addPlayedGame(\AppPhotoBundle\Entity\Game $playedGame)
    {
        $this->playedGames[] = $playedGame;

        return $this;
    }

    /**
     * Remove playedGame
     *
     * @param \AppPhotoBundle\Entity\Game $playedGame
     */
    public function removePlayedGame(\AppPhotoBundle\Entity\Game $playedGame)
    {
        $this->playedGames->removeElement($playedGame);
    }

    /**
     * Get playedGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayedGames()
    {
        return $this->playedGames;
    }

    /**
     * Add proposition
     *
     * @param \AppPhotoBundle\Entity\GameAnswer $proposition
     *
     * @return User
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
     * Set score
     *
     * @param integer $score
     *
     * @return User
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
