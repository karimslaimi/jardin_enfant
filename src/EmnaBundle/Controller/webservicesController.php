<?php

namespace EmnaBundle\Controller;

use AppBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * WebServices controller.
 *
 * @Route("Api")
 */
class webservicesController extends Controller
{


    /**
     *
     *
     * @Route("/listevents", name="lisevenement_api")
     */
    //liste des événements: pour parents et resp jardin

    public function evenemenetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
            FROM AppBundle:Evenement e'   );


        $list = $query->getArrayResult();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted= $serializer->normalize($list, 'json');


        return new JsonResponse($formatted);
    }


    /**
     * Lists all parent entities.
     *
     * @Route("/event/{id}", name="evenement_api")
     */
    //liste des événements: pour parents et resp jardin

    public function evenemenetsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
    FROM AppBundle:Evenement e WHERE e.id=:id'
        )
            ->setParameter('id', $id);

        $list = $query->getArrayResult();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted= $serializer->normalize($list, 'json');


        return new JsonResponse($formatted);
    }

//ajouter événement pour le resp jardin

    public function AjoutAction($id)
    {


    }

    //supprimer un événement pour resp jardin

    public function supprimereventAction($id)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($em->getRepository(Evenement::class)->find($id));
            $em->flush();
            return new JsonResponse(true);

        } catch (\Exception $exception) {
            return new JsonResponse(false);
        }
    }





}
