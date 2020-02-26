<?php

namespace KarimBundle\Controller;

use AppBundle\Entity\Remarque;
use KarimBundle\Form\RemarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Remarque controller.
 *
 * @\Symfony\Component\Routing\Annotation\Route("remarque")
 */
class RemarqueController extends Controller
{
    /**
     * Lists all remarque entities.
     *
     * @Route("/{page}", name="remarque_index",defaults={"page"=1},methods={"GET"})
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $remarques = $em->getRepository('AppBundle:Remarque')->findAll();

        $paginator  = $this->get('knp_paginator');


        $rq = $paginator->paginate(
            $remarques,
            $page /*page number*/,
            100 /*limit per page*/
        );

        return $this->render('@Karim/remarque/index.html.twig', array(
            'remarques' => $rq,
        ));
    }

    /**
     * Creates a new remarque entity.
     *
     * @Route("/new", name="remarque_new",methods={"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $remarque = new Remarque();
        $form = $this->createForm(RemarqueType::class, $remarque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($remarque);
            $em->flush();

            return $this->redirectToRoute('remarque_show', array('id' => $remarque->getId()));
        }

        return $this->render('@Karim/remarque/new.html.twig', array(
            'remarque' => $remarque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a remarque entity.
     *
     * @Route("/{id}", name="remarque_show",methods={"GET"})
     */
    public function showAction(Remarque $remarque)
    {
        $deleteForm = $this->createDeleteForm($remarque);

        return $this->render('@Karim/remarque/show.html.twig', array(
            'remarque' => $remarque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing remarque entity.
     *
     * @Route("/{id}/edit", name="remarque_edit",methods={"GET", "POST"})
     */
    public function editAction(Request $request, Remarque $remarque)
    {
        $deleteForm = $this->createDeleteForm($remarque);
        $editForm = $this->createForm(RemarqueType::class, $remarque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('remarque_edit', array('id' => $remarque->getId()));
        }

        return $this->render('@Karim/remarque/edit.html.twig', array(
            'remarque' => $remarque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a remarque entity.
     *
     * @Route("/{id}", name="remarque_delete",methods={"DELETE"})
     */
    public function deleteAction(Request $request, Remarque $remarque)
    {
        $form = $this->createDeleteForm($remarque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($remarque);
            $em->flush();
        }

        return $this->redirectToRoute('remarque_index');
    }

    /**
     * Creates a form to delete a remarque entity.
     *
     * @param Remarque $remarque The remarque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Remarque $remarque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('remarque_delete', array('id' => $remarque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
