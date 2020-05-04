<?php

namespace FeridBundle\Controller;

use AppBundle\Entity\Abonnement;
use AppBundle\Entity\Chauffeur;
use AppBundle\Entity\Enfant;
use AppBundle\Entity\Jardin;
use AppBundle\Entity\Parents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
/**
 * Abonnement controller.
 *
 * @Route("webservices")
 */
class WebServicesController extends Controller
{
    /**
     * @Route("/listeenf/{id}", name="java_listenf",methods={"GET"})
     */

    public function indexAction(Request $request,$id)
    {



       // $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository('AppBundle:Enfant')->getsEnfant($id);



        return new JsonResponse($enfants);
    }





    /**
     * @Route("/ajoutenf/{idp}/{nom}/{prenom}/{sexe}/{date}", name="ajenf")
     */

    public function AjouterenfAction(Request $request,$idp,$nom,$prenom,$sexe,$date)
    {
        $enf=new Enfant();
        $enf->setParent($this->getDoctrine()->getManager()->getRepository(Parents::class)->find($idp));
        $enf->setNom($nom);
        $enf->setPrenom($prenom);
        $enf->setSexe($sexe);
        $enf->setDatenaiss(New \DateTime($date));



        $ex="succes";
            $em=$this->getDoctrine()->getManager();
            $em->persist($enf);
            $em->flush();

            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($ex);
            return new JsonResponse($formatted);}




    /**
     * @Route("/ajoutabo/{ide}/{idj}/{type}/{etat}/{date}/{montant}", name="ajabo")
     */

    public function AjouterabfAction(Request $request,$ide,$idj,$type,$etat,$date,$montant)
    {
        $abo=new Abonnement();
        $abo->setEnfant($this->getDoctrine()->getManager()->getRepository(Enfant::class)->find($ide));
        $abo->setJardin($this->getDoctrine()->getManager()->getRepository(Jardin::class)->find($idj));
        $abo->setType($type);
        $abo->setEtat($etat);
        $abo->setDate(New \DateTime($date));
        $abo->setMontant($montant);



        $ex="succes";
        $em=$this->getDoctrine()->getManager();
        $em->persist($abo);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);}


    /**
     * @Route("/modifabo/{ide}/{type}/{montant}", name="modiabo")
     */

    public function ModifierabfAction(Request $request,$ide,$type,$montant)
    {
        $abo=$this->getDoctrine()->getManager()->getRepository(Abonnement::class)->find($ide);

        $abo->setType($type);


        $abo->setMontant($montant);



        $ex="succes";
        $em=$this->getDoctrine()->getManager();

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);}


    /**
     * @Route("/modifenf/{ide}/{nom}/{prenom}/{sexe}/{date}", name="modienf")
     */

    public function ModifierenffAction(Request $request,$ide,$nom,$prenom,$sexe,$date)
    {
        $enfants=$this->getDoctrine()->getManager()->getRepository(Enfant::class)->find($ide);

        $enfants->setNom($nom);
        $enfants->setPrenom($prenom);
        $enfants->setSexe($sexe);
        $enfants->setDatenaiss(New \DateTime($date));






        $ex="succes";
        $em=$this->getDoctrine()->getManager();

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);}




        /**
     * @Route("/listeabo/{id}", name="listf",methods={"GET"})
     */

    public function listaboAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('AppBundle:Abonnement')->getsAbonnement($id);



        return new JsonResponse($abonnement);
    }
    /**
     * @Route("/montant/{id}", name="mont",methods={"GET"})
     */

    public function montanAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $montant = $em->getRepository('AppBundle:Jardin')->getsMontant($id);



        return new JsonResponse($montant);
    }




    /**
     * @Route("/listeabojardin/{id}", name="listabjardi",methods={"GET"})
     */

    public function listabojardinAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('AppBundle:Abonnement')->getsAbonnementjardin($id);

        return new JsonResponse($abonnement);
    }



}

