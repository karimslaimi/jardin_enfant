<?php

namespace AppBundle\Repository;

/**
 * AbonnementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbonnementRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchAbonnements($search,$id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Abonnement m JOIN m.enfant e where  (e.nom like :motcle or e.prenom like :motcle or m.etat like :motcle or m.type like :motcle ) and m.jardin=:id")
            ->setParameter('motcle','%'.$search.'%')
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }
}
