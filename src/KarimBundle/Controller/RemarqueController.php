<?php

namespace KarimBundle\Controller;

use AppBundle\Entity\Remarque;
use KarimBundle\Form\RemarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Remarque controller.
 *
 * @Route("remarque")
 */
class RemarqueController extends Controller
{
    /**
     * Lists all remarque entities.
     *
     * @Route("/", name="remarque_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $remarques = $em->getRepository('AppBundle:Remarque')->findAll();

        return $this->render('@Karim/remarque/index.html.twig', array(
            'remarques' => $remarques,
        ));
    }

    /**
     * Creates a new remarque entity.
     *
     * @Route("/new", name="remarque_new")
     * @Method({"GET", "POST"})
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
     * @Route("/{id}", name="remarque_show")
     * @Method("GET")
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
     * @Route("/{id}/edit", name="remarque_edit")
     * @Method({"GET", "POST"})
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
     * @Route("/{id}", name="remarque_delete")
     * @Method("DELETE")
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
