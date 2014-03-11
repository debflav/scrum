<?php

namespace Override\ScrumBundle\Entity;

use Override\ScrumBundle\Entity\User as Utilisateur;
use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\ProfesseurRepository")
 */
class Professeur extends Utilisateur
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
