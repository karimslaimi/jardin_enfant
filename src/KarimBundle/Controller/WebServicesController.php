<?php

namespace KarimBundle\Controller;

use AppBundle\Entity\Abonnement;
use AppBundle\Entity\Enfant;
use AppBundle\Entity\Messages;
use AppBundle\Entity\Parents;
use AppBundle\Entity\Reclamation;
use AppBundle\Entity\Remarque;
use AppBundle\Entity\Tuteur;
use AppBundle\Repository\RemarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
/**
 * WebService controller.
 *
 * @Route("Api")
 */
class WebServicesController extends Controller
{

    /**
     * Lists my remarks entities.
     *
     * @Route("/listrem/{par}", name="remarques_api",methods={"GET"})

     */
    public function listremarquesAction($par)
    {
        //maybe usefull for reponsable jardin and the admin
        $em = $this->getDoctrine()->getManager();

        $remarques = $em->getRepository(Remarque::class)->getremarques($par);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer));
        $formatted= $serializer->normalize($remarques);


        return new JsonResponse($formatted);

    }

    /**
     * Lists all parent entities.
     *
     * @Route("/listpar", name="parents_index_api")

     */
    public function indexAction()
    {
        //maybe usefull for reponsable jardin and the admin
        $em = $this->getDoctrine()->getManager();

        $parents = $em->getRepository('AppBundle:Parents')->find(8);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });
        $serializer = new Serializer(array($normalizer));
        $formatted= $serializer->normalize($parents);


        return new JsonResponse($formatted);

    }






    /**
     *add remarks
     *
     * @Route("/addrem", name="add_remark_api")

     */
    public function Adddrem(Request $request){
        $em=$this->getDoctrine()->getManager();
        $tut=$em->getRepository(Tuteur::class)->find($request->get("tut"));
        $abo=$em->getRepository(Abonnement::class)->find($request->get("abo"));


        $date=new \DateTime("now");

        $desc=$request->get("descr");

        $remark=new Remarque();
        $remark->setAbonnement($abo);
        $remark->setDate($date);
        $remark->setDescription($desc);
        $remark->setTuteur($tut);
        $em->persist($remark);
        $em->flush();


        if($em->contains($remark)){
            return new JsonResponse("success");
        }else{
            return new JsonResponse("error");
        }


    }

    /**
     *add reclam
     *
     * @Route("/addreclam", name="add_reclam_api")

     */
    public function sendreclamAction(Request $request){

        $em=$this->getDoctrine()->getManager();
        $parent=$em->getRepository(Parents::class)->find($request->get("par"));
        $reclam=new Reclamation();

        $reclam->setParent($parent);

        $reclam->setDescription($request->get("description"));
        $reclam->setDate(new \DateTime());
        $reclam->setTitre($request->get("titre"));
        $reclam->setNom($parent->getNom()." ".$parent->getPrenom());
        $reclam->setNumtel($parent->getNumtel());
        $reclam->setEtat("en attente");
        $reclam->setMail($parent->getEmail());

        $em->persist($reclam);
        $em->flush();

        if($em->contains($reclam)){
            return new JsonResponse("success");
        }else{
            return new JsonResponse("error");
        }





    }


    // for parent



    /**
     *listjars
     *
     * @Route("/jardmess", name="listjarsmess_api")

     */
    public function jardlistAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $jars=$em->getRepository(Messages::class)->getlistjard($request->get("par"));
        return new JsonResponse($jars);

    }

    /**
     *listmessages
     *
     * @Route("/mymsg", name="list_messages_api")

     */
    public function message(Request $request){
        $em=$this->getDoctrine()->getManager();
        $messages=$em->getRepository(Messages::class)->getjardmess($request->get("par"),$request->get("jar"));
        return new JsonResponse($messages);

    }


    /**
     *listmessages
     *
     * @Route("/usermlist", name="list_muser_api")

     */
    public function userlist(Request $request){
        $em=$this->getDoctrine()->getManager();
        $messages=$em->getRepository(Messages::class)->getusermlist($request->get("jar"));
        return new JsonResponse($messages);

    }








}
