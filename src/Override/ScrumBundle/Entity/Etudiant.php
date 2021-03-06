<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\EtudiantRepository")
 */
class Etudiant
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
     * @ORM\OneToOne(targetEntity="Override\FosUserBundle\Entity\User", cascade={"remove"})
     */
    private $user;

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

    /**
     * Set user
     *
     * @param \Override\FosUserBundle\Entity\User $user
     * @return Etudiant
     */
    public function setUser(\Override\FosUserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Override\FosUserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
