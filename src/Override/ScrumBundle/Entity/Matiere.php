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
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Override\ScrumBundle\Entity\Professeur", cascade={"persist"})
     */
    private $professeur;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Override\ScrumBundle\Entity\Thematique", cascade={"persist"})
     */
    private $thematique;

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


    /**
     * Set professeur
     *
     * @param \Override\ScrumBundle\Entity\Professeur $professeur
     * @return Matiere
     */
    public function setProfesseur(\Override\ScrumBundle\Entity\Professeur $professeur = null)
    {
        $this->professeur = $professeur;
    
        return $this;
    }

    /**
     * Get professeur
     *
     * @return \Override\ScrumBundle\Entity\Professeur 
     */
    public function getProfesseur()
    {
        return $this->professeur;
    }

    /**
     * Set thematique
     *
     * @param \Override\ScrumBundle\Entity\Thematique $thematique
     * @return Matiere
     */
    public function setThematique(\Override\ScrumBundle\Entity\Thematique $thematique = null)
    {
        $this->thematique = $thematique;
    
        return $this;
    }

    /**
     * Get thematique
     *
     * @return \Override\ScrumBundle\Entity\Thematique 
     */
    public function getThematique()
    {
        return $this->thematique;
    }

    /**
     * Add professeur
     *
     * @param \Override\ScrumBundle\Entity\Professeur $professeur
     * @return Matiere
     */
    public function addProfesseur(\Override\ScrumBundle\Entity\Professeur $professeur)
    {
        $this->professeur[] = $professeur;
    
        return $this;
    }

    /**
     * Remove professeur
     *
     * @param \Override\ScrumBundle\Entity\Professeur $professeur
     */
    public function removeProfesseur(\Override\ScrumBundle\Entity\Professeur $professeur)
    {
        $this->professeur->removeElement($professeur);
    }
}
