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
//	/**
//	 * One Game has One Leader.
//	 * @OneToOne(targetEntity="User")
//	 * @JoinColumn(name="user_id", referencedColumnName="id")
//	 */

	/**
	 * One Game has One To guess Image.
	 * @OneToOne(targetEntity="Image")
	 * @JoinColumn(name="to_guess_image_id", referencedColumnName="id")
	 */

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
}
