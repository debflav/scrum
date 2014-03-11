<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\FormationRepository")
 */
class Formation
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Descriptif", type="text")
     */
    private $descriptif;

    /**
     * @ORM\ManyToOne(targetEntity="Override\ScrumBundle\Entity\Cursus", cascade={"persist"})
     */
    private $cursus;

    /**
    * @ORM\ManyToOne(targetEntity="Override\ScrumBundle\Entity\SecretaireFormation", cascade={"persist"})
    */
    private $secretaireFormation;

    /* Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Formation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set descriptif
     *
     * @param string $descriptif
     * @return Formation
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }

    /**
     * Set cursus
     *
     * @param \Override\ScrumBundle\Entity\Cursus $cursus
     * @return Formation
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

    /**
     * Set secretaireFormation
     *
     * @param \Override\ScrumBundle\Entity\Secretaire_formation $secretaireFormation
     * @return Formation
     */
    public function setSecretaireFormation(\Override\ScrumBundle\Entity\Secretaire_formation $secretaireFormation = null)
    {
        $this->secretaireFormation = $secretaireFormation;

        return $this;
    }

    /**
     * Get secretaireFormation
     *
     * @return \Override\ScrumBundle\Entity\Secretaire_formation
     */
    public function getSecretaireFormation()
    {
        return $this->secretaireFormation;
    }
}
