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
