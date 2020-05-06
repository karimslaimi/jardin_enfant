<?php

namespace AppBundle\Repository;

/**
 * EnfantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EnfantRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchEnfant($search,$id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Enfant m JOIN m.parent e where  (m.nom like :motcle or m.prenom like :motcle ) and m.parent=:id")
            ->setParameter('motcle','%'.$search.'%')
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }

    public function getsEnfant($id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m.id,m.nom,m.prenom,p.id AS parent,m.datenaiss AS naiss,m.sexe from AppBundle:Enfant m ,AppBundle:Parents p where m.parent=p.id and  m.parent=:id")
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }

    public function getEnfantenf($id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m.id,m.nom,m.prenom,m.datenaiss AS naiss,m.sexe from AppBundle:Enfant m where m.id=:id")
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }






    public function getmesenfant($id,$jar){
        $q=$this->getEntityManager()->createQuery("select a from AppBundle:Enfant a
        Join AppBundle:Abonnement ab with a=ab.enfant where a.parent=:parent and ab.jardin=:jardin")
            ->setParameter('parent',$id)->setParameter('jardin',$jar);
        return $query=$q->getResult();
    }

    public function getenfantjardin($jar){
        $q=$this->getEntityManager()->createQuery("select m.id,m.nom,m.prenom,m.datenaiss AS naiss,m.sexe from AppBundle:Enfant m
        Join AppBundle:Abonnement ab with m=ab.enfant  where   ab.jardin=:jardin")
            ->setParameter('jardin',$jar);
        return $query=$q->getResult();
    }
}
