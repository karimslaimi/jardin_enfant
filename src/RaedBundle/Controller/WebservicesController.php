<?php

namespace RaedBundle\Controller;

use AppBundle\Entity\Jardin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
 * WebService controller.
 *
 * @Route("Apijar")
 */
class WebservicesController extends Controller

{
    /**
     * @Route("/listjardin", name="java_listjardin",methods={"GET"})
     */

    public function indexAction(Request $request)
    {



        // $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $jardin = $em->getRepository('AppBundle:Jardin')->getJardins();



        return new JsonResponse($jardin);
    }
    /**
     * @Route("/modifjardin/{ide}/{name}/{description}/{numtel}/{tarif}/{adresse}/{etat]", name="modijardin")
     */
    public function ModifierjardinfAction(Request $request,$ide,$name,$description,$numtel,$tarif ,$adresse, $etat)
    {

        $jardin=$this->getDoctrine()->getManager()->getRepository(Jardin::class)->find($ide) ;
        $jardin->setName($name);
        $jardin->setDescription($description);
        $jardin->setNumtel($numtel);
        $jardin-> setTarif($tarif);
        $jardin->setAdresse($adresse);
        $jardin->setEtat($etat);

        $ex="succes";
        $em=$this->getDoctrine()->getManager();

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);


    }

}
