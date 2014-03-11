<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secretaire_formation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Override\ScrumBundle\Entity\SecretaireFormationRepository")
 */
class SecretaireFormation
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
     * @ORM\OneToOne(targetEntity="Override\ScrumBundle\Entity\User", cascade={"persist"})
     */
    private $user;


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
