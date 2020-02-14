<?php

namespace FeridBundle\Controller;

use AppBundle\Entity\Abonnement;
use FeridBundle\Form\AbonnementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Abonnement controller.
 *
 * @Route("abonnement")
 */
class AbonnementController extends Controller
{
    /**
     * Lists all abonnement entities.
     *
     * @Route("/index", name="abonnement_index",methods={"GET","HEAD"})
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $abonnements = $em->getRepository(Abonnement::class)->findAll();

        return $this->render('@Ferid/abonnement/index.html.twig', array(
            'abonnements' => $abonnements,
        ));
    }

    /**
     * Creates a new abonnement entity.
     *
     * @Route("/new", name="abonnement_new",methods={"GET", "POST"})

     */
    public function newAction(Request $request)
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abonnement);
            $em->flush();

            return $this->redirectToRoute('abonnement_show', array('id' => $abonnement->getId()));
        }

        return $this->render('@Ferid/abonnement/new.html.twig', array(
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a abonnement entity.
     *
     * @Route("/{id}", name="abonnement_show",methods={"GET","HEAD"})

     */
    public function showAction(Abonnement $abonnement)
    {
        $deleteForm = $this->createDeleteForm($abonnement);

        return $this->render('@Ferid/abonnement/show.html.twig', array(
            'abonnement' => $abonnement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing abonnement entity.
     *
     * @Route("/{id}/edit", name="abonnement_edit",methods={"GET", "POST"})

     */
    public function editAction(Request $request, Abonnement $abonnement)
    {
        $deleteForm = $this->createDeleteForm($abonnement);
        $editForm = $this->createForm(AbonnementType::class, $abonnement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() ) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abonnement_show', array('id' => $abonnement->getId()));
        }

        return $this->render('@Ferid/abonnement/edit.html.twig', array(
            'abonnement' => $abonnement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a abonnement entity.
     *
     * @Route("/{id}", name="abonnement_delete",methods={"DELETE"})

     */
    public function deleteAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createDeleteForm($abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonnement);
            $em->flush();
        }

        return $this->redirectToRoute('abonnement_index');
    }

    /**
     * Creates a form to delete a abonnement entity.
     *
     * @param Abonnement $abonnement The abonnement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abonnement $abonnement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonnement_delete', array('id' => $abonnement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
