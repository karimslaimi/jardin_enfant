<?php

namespace SamiBundle\Controller;

use AppBundle\Entity\Tuteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Tuteur controller.
 *
 * @Route("tuteur")
 */
class TuteurController extends Controller
{
    /**
     * Lists all tuteur entities.
     *
     * @Route("/", name="tuteur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tuteurs = $em->getRepository('AppBundle:Tuteur')->findAll();

        return $this->render('@Sami/tuteur/index.html.twig', array(
            'tuteurs' => $tuteurs,
        ));
    }

    /**
     * Finds and displays a tuteur entity.
     *
     * @Route("/{id}", name="tuteur_show")
     * @Method("GET")
     */
    public function showAction(Tuteur $tuteur)
    {

        return $this->render('@Sami/tuteur/show.html.twig', array(
            'tuteur' => $tuteur,
        ));
    }
}
