<?php

namespace AppBundle\Repository;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * PaiementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaiementRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPaiement($id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT e.name ,e.numtel,e.description,p.date ,p.montant from AppBundle:Jardin e
         join AppBundle:Paiement p with p.jardin=e
          where e.id=:id ")
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }



}
