<?php

namespace AppPhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameAnswer
 *
 * @ORM\Table(name="game_answer")
 * @ORM\Entity(repositoryClass="AppPhotoBundle\Repository\GameAnswerRepository")
 */
class GameAnswer
{
	/**
	 * Many GameAnswer have One image.
	 * @ORM\ManyToOne(targetEntity="Image")
	 * @ORM\JoinColumn(name="image_id", referencedColumnName="id", cascade={"persist", "remove"})
	 */
	protected $image;


	/**
	 * Many GameAnswer have One User.
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="answers")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $user;

	/**
	 * Many GameAnswer have One Game.
	 * @ORM\ManyToOne(targetEntity="Game", inversedBy="answers")
	 * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
	 */
	protected $game;

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
     * Set image
     *
     * @param \AppPhotoBundle\Entity\Image $image
     *
     * @return GameAnswer
     */
    public function setImage(\AppPhotoBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppPhotoBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \AppPhotoBundle\Entity\User $user
     *
     * @return GameAnswer
     */
    public function setUser(\AppPhotoBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppPhotoBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set game
     *
     * @param \AppPhotoBundle\Entity\Game $game
     *
     * @return GameAnswer
     */
    public function setGame(\AppPhotoBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppPhotoBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }
}
