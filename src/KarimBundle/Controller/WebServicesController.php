<?php

namespace KarimBundle\Controller;

use AppBundle\Entity\Remarque;
use AppBundle\Repository\RemarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
/**
 * WebService controller.
 *
 * @Route("Api")
 */
class WebServicesController extends Controller
{

    /**
     * Lists my remarks entities.
     *
     * @Route("/listrem/{par}", name="remarques_api",methods={"GET"})

     */
    public function listremarquesAction($par)
    {
        //maybe usefull for reponsable jardin and the admin
        $em = $this->getDoctrine()->getManager();

        $remarques = $em->getRepository(Remarque::class)->getremarques($par);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted= $serializer->serialize($remarques, 'json');


        return new JsonResponse($formatted);

    }

    /**
     * Lists all parent entities.
     *
     * @Route("/listpar", name="parents_index_api")

     */
    public function indexAction()
    {
        //maybe usefull for reponsable jardin and the admin
        $em = $this->getDoctrine()->getManager();

        $parents = $em->getRepository('AppBundle:Parents')->find(8);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted= $serializer->serialize($parents, 'json');


        return new JsonResponse($formatted);

    }








    public function Adddrem(){

    }











}
