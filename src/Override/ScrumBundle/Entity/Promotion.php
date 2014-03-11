<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\PromotionRepository")
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Identifiant", type="string", length=255)
     */
    private $identifiant;

    /**
     * @ORM\ManyToOne(targetEntity="Override\ScrumBundle\Entity\Cursus", cascade={"persist"})
     */
    private $cursus;

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
     * Set identifiant
     *
     * @param string $identifiant
     * @return Promotion
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string 
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set cursus
     *
     * @param \Override\ScrumBundle\Entity\Cursus $cursus
     * @return Promotion
     */
    public function setCursus(\Override\ScrumBundle\Entity\Cursus $cursus = null)
    {
        $this->cursus = $cursus;

        return $this;
    }

    /**
     * Get cursus
     *
     * @return \Override\ScrumBundle\Entity\Cursus 
     */
    public function getCursus()
    {
        return $this->cursus;
    }
}
