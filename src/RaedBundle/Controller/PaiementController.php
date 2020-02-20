<?php

namespace RaedBundle\Controller;

use AppBundle\Entity\Paiement;

use Symfony\Component\HttpFoundation\Response;
use RaedBundle\Form\PaiementType;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paiement controller.
 *
 * @Route("paiement")
 */
class PaiementController extends Controller
{
    /**
     * Lists all paiement entities.
     *
     * @Route("/", name="paiement_index")
     * @Method("GET")
     */
    public function indexAction()
    {


        $em = $this->getDoctrine()->getManager();

        $paiements = $em->getRepository('AppBundle:Paiement')->findAll();

        return $this->render('@Raed/paiement/index.html.twig', array(
            'paiements' => $paiements,
        ));
    }

    /**
     * Creates a new paiement entity.
     *
     * @Route("/new", name="paiement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        if($request->isMethod("GET")){
            return $this->render('@Raed/paiement/new.html.twig');
        }else {


            \Stripe\Stripe::setApiKey('sk_test_4JsTkhR1jl9inK7aFCOIB2R200xZ1BTW3D');

            try {
                $charges = Charge::create(array(
                    "amount" => 1000,
                    "currency" => "usd",
                    "source" => $request->get('stripeToken'),
                    "description" => "Test Charges"
                ));
                /*
                \Stripe\Charge::create([
                    'amount' => 2000,
                    'currency' => 'eur',
                    'source' => $request->request->get('stripeToken'),
                    'description' => "Paiement de test"
                ])*/
                $order = new Order();
                //$order->cart = serialize($cart);
                $order->address = $request->input('address');
                $order->name = $request->input('name');
                $order->payment_id = $charges->id;

                Auth::user()->orders()->save($order);
                return new Response("worked1");

            } catch (ApiErrorException $e) {

                return new Response("worked");

            }
        }
            return $this->render('@@Raed/paiement/new.html.twig', array("prix" => $prix));





    }

    /**
     * Finds and displays a paiement entity.
     *
     * @Route("/{id}", name="paiement_show")
     * @Method("GET")
     */
    public function showAction(Paiement $paiement)
    {
        $deleteForm = $this->createDeleteForm($paiement);

        return $this->render('@Raed/paiement/show.html.twig', array(
            'paiement' => $paiement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paiement entity.
     *
     * @Route("/{id}/edit", name="paiement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Paiement $paiement)
    {
        $deleteForm = $this->createDeleteForm($paiement);
        $editForm = $this->createForm(PaiementType::class, $paiement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_edit', array('id' => $paiement->getId()));
        }

        return $this->render('@Raed/paiement/edit.html.twig', array(
            'paiement' => $paiement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paiement entity.
     *
     * @Route("/{id}", name="paiement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Paiement $paiement)
    {
        $form = $this->createDeleteForm($paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paiement);
            $em->flush();
        }

        return $this->redirectToRoute('paiement_index');
    }

    /**
     * Creates a form to delete a paiement entity.
     *
     * @param Paiement $paiement The paiement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paiement $paiement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paiement_delete', array('id' => $paiement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
