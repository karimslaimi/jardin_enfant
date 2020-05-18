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
    public function searchAbonnements($search,$id,$tris)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Abonnement m JOIN m.enfant e where  (e.nom like :motcle or e.prenom like :motcle or m.etat like :motcle or m.type like :motcle ) and m.jardin=:id order by m.etat ".$tris)
            ->setParameter('motcle','%'.$search.'%')
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }


    public function searchAbonnemParent($search,$id,$tri)
    {
        $q=$this->getEntityManager()->createQuery("SELECT m from AppBundle:Abonnement m JOIN m.enfant e where  (e.nom like :motcle or e.prenom like :motcle or m.etat like :motcle or m.type like :motcle or m.date like :motcle ) and e.parent=:id order by e.nom ".$tri)
            ->setParameter('motcle','%'.$search.'%')
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }

    public function countEnfants($id)
    {

        $q=$this->getEntityManager()->createQueryBuilder('cc')
            ->select('cc')
            ->from('AppBundle:Abonnement',"cc")
            ->where('cc.jardin = :id')
            ->setParameter('id', $id)
            ->distinct()
            ->getQuery();
        return $query=$q->getResult();

    }

    public function getsAbonnement($id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT a.id,j.name,j.id AS idj,e.nom,e.prenom,a.type,a.etat,a.date AS dateab  from AppBundle:Enfant e ,AppBundle:Abonnement a ,AppBundle:Jardin j where a.enfant=e.id and a.jardin=j.id and e.parent=:id")
            ->setParameter('id',$id);
        return $query=$q->getResult();

    }
    public function getsAbonnementjardin($id)
    {
        $q=$this->getEntityManager()->createQuery("SELECT a.id,p.numtel,e.nom,e.prenom,a.type,a.etat,a.date AS dateab from AppBundle:Enfant e ,AppBundle:Abonnement a ,AppBundle:Jardin j ,AppBundle:Parents p where a.enfant=e.id and e.parent=p.id and a.jardin=j.id and a.etat=:et and a.jardin=:id")
            ->setParameter('id',$id)
            ->setParameter('et',"accepté");

        return $query=$q->getResult();

    }

}
