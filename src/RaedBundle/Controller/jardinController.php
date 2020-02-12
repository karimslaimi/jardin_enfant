<?php

namespace RaedBundle\Controller;

use AppBundle\Entity\Jardin;
use RaedBundle\Form\jardinType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Jardin controller.
 *
 * @Route("jardin")
 */
class jardinController extends Controller
{
    /**
     * Lists all jardin entities.
     *
     * @Route("/", name="jardin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jardins = $em->getRepository('AppBundle:Jardin')->findAll();

        return $this->render('@Raed/jardin/index.html.twig', array(
            'jardins' => $jardins,
        ));
    }

    /**
     * Creates a new jardin entity.
     *
     * @Route("/new", name="jardin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jardin = new Jardin();
        $form = $this->createForm(jardinType::class, $jardin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jardin);
            $em->flush();

            return $this->redirectToRoute('jardin_show', array('id' => $jardin->getId()));
        }

        return $this->render('@Raed/jardin/new.html.twig', array(
            'jardin' => $jardin,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jardin entity.
     *
     * @Route("/{id}", name="jardin_show")
     * @Method("GET")
     */
    public function showAction(jardin $jardin)
    {
        $deleteForm = $this->createDeleteForm($jardin);

        return $this->render('@Raed/jardin/show.html.twig', array(
            'jardin' => $jardin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jardin entity.
     *
     * @Route("/{id}/edit", name="jardin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, jardin $jardin)
    {
        $deleteForm = $this->createDeleteForm($jardin);
        $editForm = $this->createForm(jardinType::class, $jardin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jardin_edit', array('id' => $jardin->getId()));
        }

        return $this->render('@Raed/jardin/edit.html.twig', array(
            'jardin' => $jardin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jardin entity.
     *
     * @Route("/{id}", name="jardin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, jardin $jardin)
    {
        $form = $this->createDeleteForm($jardin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jardin);
            $em->flush();
        }

        return $this->redirectToRoute('jardin_index');
    }

    /**
     * Creates a form to delete a jardin entity.
     *
     * @param jardin $jardin The jardin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(jardin $jardin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jardin_delete', array('id' => $jardin->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
