<?php

namespace KarimBundle\Controller;

use AppBundle\Entity\Messages;
use AppBundle\Entity\Parents;
use AppBundle\Repository\ParentRepository;
use KarimBundle\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Message controller.
 *
 * @Route("messages")
 */
class MessagesController extends Controller
{


    /**
     * Lists all message entities.
     *
     * @Route("/msg", name="messages_i",methods={"GET","HEAD"})
     */
    public function lsAction(){

        $tab=$this->getDoctrine()->getManager()->getRepository(Messages::class)->getmessages(2);
       return $this->render('@Karim/messages/index.html.twig',array("messages"=>$tab));
    }




    /**
     * Lists all message entities.
     *
     * @Route("/{id}", name="messages_index",defaults={"id" = null},methods={"GET","HEAD"})
     */
    public function indexAction($id)
    {
        $messages=$this->getDoctrine()->getManager()->getRepository(Messages::class)->getallmess();
        if($id!=null){
            $tab=$this->getDoctrine()->getManager()->getRepository(Messages::class)->getmessages($id);
        }else{
            $this->redirectToRoute("messages_i");
        }





        return $this->render('@Karim/messages/index.html.twig', array(
            'messages' => $messages,
            "mess"=>$tab
        ));
    }
    /**
     * add msg.
     *
     * @Route("/addmess", name="addmess",methods={"POST"})
     */
    public function addmessction(Request $request)
    {

        $mes=$request->get('msg');
        $message=new Messages();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if(in_array("ROLE_RESPONSABLE" , $user->getRoles())){

            $message->setJardin($user->getJardin());
            }
        $message->setParent($request->get("id"));






        return $this->redirectToRoute('messages_index');
    }

    /**
     * Creates a new message entity.
     *
     * @Route("/new", name="messages_new")
     */
    public function newAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $time=new \DateTime();
            $message->setDate($time->format('Y-m-d H:i:s'));


            $id=4;


            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user!=null){
                $message->setParent($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
            }else{
                $message->setParent( $em->getRepository(Parents::class)->find($id));
            }




            return $this->redirectToRoute('messages_show', array('id' => $message->getId()));
        }

        return $this->render('@Karim/messages/new.html.twig', array(
            'message' => $message,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     * @Route("/{id}", name="messages_show",methods={"GET","HEAD"})
     */
    public function showAction(Messages $message)
    {
        $deleteForm = $this->createDeleteForm($message);

        return $this->render('@Karim/messages/show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     * @Route("/{id}/edit", name="messages_edit",methods={"GET","POST"})
     */
    public function editAction(Request $request, Messages $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm(MessagesType::class, $message);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->merge($message);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('messages_show', array('id' => $message->getId()));
        }

        return $this->render('@Karim/messages/edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a message entity.
     *
     * @Route("Delete/{id}", name="messages_delete",methods={"DELETE"})
     */
    public function deleteAction(Request $request, Messages $message)
    {
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('messages_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Messages $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Messages $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('messages_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
