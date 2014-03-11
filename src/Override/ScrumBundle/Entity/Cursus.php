<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\CursusRepository")
 */
class Cursus
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
     * @ORM\Column(name="Annee", type="string", length=255)
     */
    private $annee;


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
     * Set annee
     *
     * @param string $annee
     * @return Cursus
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }
}
