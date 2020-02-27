<?php

namespace AppBundle\Repository;

/**
 * ActiviteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActiviteRepository extends \Doctrine\ORM\EntityRepository
{
    public function RechercheActivite($search)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Activite m  where  (m.typeact like :motcle or m.detailles like :motcle )")
            ->setParameter('motcle','%'.$search.'%');

        return $query=$q->getResult();

    }

    public function getActivities($id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Activite m JOIN AppBundle:Club e where m.club=e.id and e.jardin=:id")
            ->setParameter('id',$id);
        return $query=$q->getResult();


    }
}
