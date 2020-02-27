<?php

namespace AppBundle\Repository;

/**
 * JardinRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JardinRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchJardins($search)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Jardin m where (m.name like :motcle)")
            ->setParameter('motcle','%'.$search.'%');
        return $query=$q->getResult();

    }
}

