<?php

namespace KarimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * Lists all parent entities.
     *
     * @Route("/listpar", name="parents_index_api")

     */
    public function indexAction()
    {
        //maybe usefull for reponsable jardin and the admin
        $em = $this->getDoctrine()->getManager();

        $parents = $em->getRepository('AppBundle:Parents')->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($parents);
        return new JsonResponse($formatted);

    }
}
