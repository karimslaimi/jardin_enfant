<?php

namespace FeridBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * Abonnement controller.
 *
 * @Route("default")
 */
class DefaultController extends Controller
{
    /**
     * * @Route("/pdf", name="abonnement_pdf",methods={"GET","HEAD"})
     */
    public function indexAction()
    {
        $snappy = $this->get("knp_snappy.pdf");
        $html = $this->renderView("@Ferid/abonnement/pdf.html.twig", array("title" => "Awesome PDF Title"));
        $filname = "custom_pdf_form_twig";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filname . '.pdf"'
            )
        );

    }


}
