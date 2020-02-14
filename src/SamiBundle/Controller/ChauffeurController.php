<?php

namespace SamiBundle\Controller;

use AppBundle\Entity\Chauffeur;
use SamiBundle\Form\ChauffeurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Chauffeur controller.
 *
 * @Route("chauffeur")
 */
class ChauffeurController extends Controller
{
    /**
     * Lists all chauffeur entities.
     *
     * @Route("/", name="chauffeur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chauffeurs = $em->getRepository(Chauffeur::class)->findAll();

        return $this->render('@Sami/chauffeur/index.html.twig', array(
            'chauffeurs' => $chauffeurs,
        ));
    }

    /**
     * Creates a new chauffeur entity.
     *
     * @Route("/new", name="chauffeur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $chauffeur = new Chauffeur();
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chauffeur);
            $em->flush();
            return $this->redirectToRoute('chauffeur_show', array('id' => $chauffeur->getId()));
        }

        return $this->render('@Sami/chauffeur/new.html.twig', array(
            'chauffeur' => $chauffeur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chauffeur entity.
     *
     * @Route("/{id}", name="chauffeur_show")
     * @Method("GET")
     */
    public function showAction(Chauffeur $chauffeur)
    {
        $deleteForm = $this->createDeleteForm($chauffeur);

        return $this->render('@Sami/chauffeur/show.html.twig', array(
            'chauffeur' => $chauffeur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chauffeur entity.
     *
     * @Route("/{id}/edit", name="chauffeur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chauffeur $chauffeur)
    {
        $deleteForm = $this->createDeleteForm($chauffeur);
        $editForm = $this->createForm(ChauffeurType::class, $chauffeur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() ) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chauffeur_edit', array('id' => $chauffeur->getId()));
        }

        return $this->render('@Sami/chauffeur/edit.html.twig', array(
            'chauffeur' => $chauffeur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chauffeur entity.
     *
     * @Route("/{id}", name="chauffeur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chauffeur $chauffeur)
    {
        $form = $this->createDeleteForm($chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chauffeur);
            $em->flush();
        }

        return $this->redirectToRoute('chauffeur_index');
    }

    /**
     * Creates a form to delete a chauffeur entity.
     *
     * @param Chauffeur $chauffeur The chauffeur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chauffeur $chauffeur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chauffeur_delete', array('id' => $chauffeur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
