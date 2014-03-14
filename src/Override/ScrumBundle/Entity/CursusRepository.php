<?php

namespace Override\ScrumBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CursusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CursusRepository extends EntityRepository
{

    public function getCursusBySecretaireId($secretaireId) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c, f, sf FROM OverrideScrumBundle:Cursus c
                    INNER JOIN c.formation f
                    INNER JOIN f.secretaireFormation sf
                    WHERE sf.id = :secretaireId
                '
            )
            ->setParameter('secretaireId', $secretaireId)
            ->getResult();
    }

    public function getCursusBySecretaireAndId($secretaireId, $id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c, f, sf FROM OverrideScrumBundle:Cursus c
                    INNER JOIN c.formation f
                    INNER JOIN f.secretaireFormation sf
                    WHERE sf.id = :secretaireId
                    AND c.id = :id
                '
            )
            ->setParameter('secretaireId', $secretaireId)
            ->setParameter('id', $id)
            ->getResult()[0];
    }
}
