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
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="text")
     */
    private $descriptif;

    /**
    * @ORM\ManyToOne(targetEntity="Override\ScrumBundle\Entity\SecretaireFormation", cascade={"persist"})
    */
    private $secretaireFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="critere", type="string", length=100)
     */
    private $critere;

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
     * Set secretaireFormation
     *
     * @param \Override\ScrumBundle\Entity\SecretaireFormation $secretaireFormation
     * @return Formation
     */
    public function setSecretaireFormation(\Override\ScrumBundle\Entity\SecretaireFormation $secretaireFormation = null)
    {
        $this->secretaireFormation = $secretaireFormation;

        return $this;
    }

    /**
     * Get secretaireFormation
     *
     * @return \Override\ScrumBundle\Entity\SecretaireFormation
     */
    public function getSecretaireFormation()
    {
        return $this->secretaireFormation;
    }

    /**
     * Set critere
     *
     * @param string $critere
     * @return Formation
     */
    public function setCritere($critere)
    {
        $this->critere = $critere;

        return $this;
    }

    /**
     * Get critere
     *
     * @return string 
     */
    public function getCritere()
    {
        return $this->critere;
    }
}
