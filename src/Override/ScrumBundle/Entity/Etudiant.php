<?php

namespace Override\ScrumBundle\Entity;

use Override\ScrumBundle\Entity\User as Utilisateur;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\EtudiantRepository")
 */
class Etudiant extends Utilisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Dernier_diplome", type="string", length=255)
     */
    private $dernierDiplome;


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
     * Set dernierDiplome
     *
     * @param string $dernierDiplome
     * @return Etudiant
     */
    public function setDernierDiplome($dernierDiplome)
    {
        $this->dernierDiplome = $dernierDiplome;

        return $this;
    }

    /**
     * Get dernierDiplome
     *
     * @return string
     */
    public function getDernierDiplome()
    {
        return $this->dernierDiplome;
    }
}