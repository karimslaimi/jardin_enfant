<?php

namespace DorraBundle\Controller;

use AppBundle\Entity\Activite;
use AppBundle\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;




/**
 * Activite controller.
 *
 * @Route("activite")
 */
class ActiviteController extends Controller
{
    /**
     * Lists all activite entities.
     *
     * @Route("/", name="activite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $activites = $em->getRepository('AppBundle:Activite')->findAll();

        return $this->render('@Dorra/activite/index.html.twig', array(
            'activites' => $activites,
        ));
    }

    /**
     * Creates a new activite entity.
     *
     * @Route("/new", name="activite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $activite = new Activite();
        $form = $this->createForm('DorraBundle\Form\ActiviteType', $activite);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $activite->getPhoto();
                if($activite->getPhoto()!=null)
                {
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    //$fileName = mdS(uniqid()).'.'.$file->queasExtintion();
                    $file->move($this->getParameter('image_directory'),$fileName);
                    $activite->setPhoto($fileName);
                }



            $em = $this->getDoctrine()->getManager();
            $activite->setClub($em->getRepository(Club::class)->find(1 ));
            $em->persist($activite);
            $em->flush();

            return $this->redirectToRoute('activite_show', array('id' => $activite->getId()));
        }

        return $this->render('@Dorra/activite/new.html.twig', array(
            'activite' => $activite,
            'form' => $form->createView(),
        ));
    }






    /**
     * calendrier
     *
     * @Route("/calendrier", name="activite_index")
     * @Method("GET")
     */
    public function AfficherCalendrier()
    {
        return $this->render('@Dorra/activite/calendrier.html.twig', array(''));
    }



    /**
     * Finds and displays a activite entity.
     *
     * @Route("/{id}", name="activite_show")
     * @Method("GET")
     */
    public function showAction(Activite $activite)
    {
        $deleteForm = $this->createDeleteForm($activite);

        return $this->render('@Dorra/activite/show.html.twig', array(
            'activite' => $activite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activite entity.
     *
     * @Route("/{id}/edit", name="activite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Activite $activite)
    {
        $deleteForm = $this->createDeleteForm($activite);
        $editForm = $this->createForm('DorraBundle\Form\ActiviteType', $activite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() ) {

            $file = $activite->getPhoto();
            if($activite->getPhoto()!=null)
            {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                //$fileName = mdS(uniqid()).'.'.$file->queasExtintion();
                $file->move($this->getParameter('image_directory'),$fileName);
                $activite->setPhoto($fileName);
            }

            $em = $this->getDoctrine()->getManager();

            //$activite->setClub($em->getRepository(Club::class)->find(1 ));
           $em->merge($activite);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activite_show', array('id' => $activite->getId()));
        }

        return $this->render('@Dorra/activite/edit.html.twig', array(
            'activite' => $activite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a activite entity.
     *
     * @Route("/delete/{id}", name="activite_delete", methods="DELETE")

     */
    public function deleteAction(Request $request, Activite $activite)
    {
        $form = $this->createDeleteForm($activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activite);
            $em->flush();
        }

        return $this->redirectToRoute('activite_index');
    }

    /**
     * Creates a form to delete a activite entity.
     *
     * @param Activite $activite The activite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Activite $activite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activite_delete', array('id' => $activite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function generateUniqueFileName()
    {

        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
