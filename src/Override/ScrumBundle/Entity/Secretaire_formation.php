<?php

namespace Override\ScrumBundle\Entity;

use Override\ScrumBundle\Entity\User as Utilisateur;
use Doctrine\ORM\Mapping as ORM;

/**
 * Secretaire_formation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\Secretaire_formationRepository")
 */
class Secretaire_formation extends Utilisateur
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
