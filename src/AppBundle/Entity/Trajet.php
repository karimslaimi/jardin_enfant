<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trajet
 *
 * @ORM\Table(name="trajet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="checkpoint", type="string", length=255)
     */
    private $checkpoint;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set checkpoint
     *
     * @param string $checkpoint
     *
     * @return Trajet
     */
    public function setCheckpoint($checkpoint)
    {
        $this->checkpoint = $checkpoint;

        return $this;
    }

    /**
     * Get checkpoint
     *
     * @return string
     */
    public function getCheckpoint()
    {
        return $this->checkpoint;
    }
}

