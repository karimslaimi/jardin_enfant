<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActiviteRepository")
 */
class Activite
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
     * @ORM\Column(name="typeact", type="string", length=255)
     */
    private $typeact;

    /**
     * @var string
     *
     * @ORM\Column(name="detailles", type="string", length=255)
     */
    private $detailles;

    /**
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="activites")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club)
    {
        $this->club = $club;
    }



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
     * Set typeact
     *
     * @param string $typeact
     *
     * @return Activite
     */
    public function setTypeact($typeact)
    {
        $this->typeact = $typeact;

        return $this;
    }

    /**
     * Get typeact
     *
     * @return string
     */
    public function getTypeact()
    {
        return $this->typeact;
    }

    /**
     * Set detailles
     *
     * @param string $detailles
     *
     * @return Activite
     */
    public function setDetailles($detailles)
    {
        $this->detailles = $detailles;

        return $this;
    }

    /**
     * Get detailles
     *
     * @return string
     */
    public function getDetailles()
    {
        return $this->detailles;
    }
}

