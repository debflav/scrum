<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\MatiereRepository")
 */
class Matiere {

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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="Coefficient", type="integer")
     */
    private $coefficient;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * Constructor
     */
    public function __construct() {
        $this->cursus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Matiere
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set coefficient
     *
     * @param integer $coefficient
     * @return Matiere
     */
    public function setCoefficient($coefficient) {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return integer 
     */
    public function getCoefficient() {
        return $this->coefficient;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Matiere
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

}
