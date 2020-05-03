<?php

namespace SamiBundle\Controller;

use AppBundle\Entity\Chauffeur;
use AppBundle\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Zend\Json\Json;

/**
 * Chauffeur controller.
 *
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * Lists all parent entities.
     *
     * @Route("/listpar/{id}", name="trajets_api")
     */
    public function trajetsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c
    FROM AppBundle:Trajet c WHERE c.chauffeur=:id'
        )
            ->setParameter('id',$id);

        $list = $query->getArrayResult();

        return new JsonResponse($list);
    }

    /**
     * Suppression d'un trajet.
     *
     * @Route("/deleteTrajet/{id}", name="trajets_supprimer")
     */
    public function supprimerTrajetAction($id)
    {
try
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($em->getRepository(Trajet::class)->find($id));
    $em->flush();
    return new JsonResponse(true);
  }
  catch (\Exception $exception)
  {
    return new JsonResponse(false);
  }

    }

    /**
     * ajout d'un trajet.
     *
     * @Route("/addTrajet", name="trajets_ajouter")
     */
    public function addTrajet(Request $request)
    {
        try{
    $chauff=$this->getDoctrine()->getManager()->getRepository(Chauffeur::class)->find($request->get('id'));
    $trajet=new Trajet();
$trajet->setHeure($request->get('heure'));
$trajet->setAdresse($request->get('adresse'));
$trajet->setChauffeur($chauff);
$this->getDoctrine()->getManager()->persist($trajet);
$this->getDoctrine()->getManager()->flush();

        return new JsonResponse(true);
    }catch (\Exception $exception)
        {
            return new JsonResponse(false);
        }
    }

}
