<?php

namespace EmnaBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Jardin;
use AppBundle\Entity\Participer;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

//use Symfony\Component\Routing\Annotation\Route;


/**
 * WebServices controller.
 *
 * @Route("/Api")
 */
class webservicesController extends Controller
{
    //liste des catégories pour le resp jardin

    /**
     *@Route("/categories", name="categories_api")

     */

    public function categoriesAPiAction()
    {
        //ît works
        $cat = $this->getDoctrine()->getManager();

        $cat = $this->getDoctrine()->getManager();
        $query = $cat->createQuery(
            'SELECT c
            FROM AppBundle:Categorie c');


        $list = $query->getArrayResult();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted = $serializer->normalize($list, 'json');


        return new JsonResponse($formatted);
    }


    /**
     *@Route("/categorieslib", name="categorieslib_api")

     */

    public function categorieslibAction()
    {
        //ît works
        $cat = $this->getDoctrine()->getManager();

        $cat = $this->getDoctrine()->getManager();
        $query = $cat->createQuery(
            'SELECT c.libelle
            FROM AppBundle:Categorie c');


        $list = $query->getArrayResult();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted = $serializer->normalize($list, 'json');


        return new JsonResponse($formatted);
    }





    /**
     *
     *
     * @Route("/listevents", name="lisevenement_api")
     */
    //liste des événements: pour parents et resp jardin

    public function evenemenetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
            FROM AppBundle:Evenement e');


        $list = $query->getArrayResult();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted = $serializer->normalize($list, 'json');


        return new JsonResponse($formatted);
    }





    /**
     *
     *
     * @Route("/listeventsJar/{idj}", name="lisevenementJar_api")
     */
    //liste des événements d'un jardin

    public function evenemenetJarAction($idj)
    {

        $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
            FROM AppBundle:Evenement e
            Where e.jardin=:idj')


        ->setParameter('idj',$idj);

        $list = $query->getArrayResult();



        return new JsonResponse($list);
    }



    /**
     *
     *
     * @Route("/event/{id}", name="evenement_api")
     */
    //détails événement: pour parents et resp jardin

    public function evenemenetsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
    FROM AppBundle:Evenement e WHERE e.id=:id'
        )
            ->setParameter('id', $id);

        $list = $query->getArrayResult();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId(); // Change this to a valid method of your object
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $formatted = $serializer->normalize($list, 'json');


        return new JsonResponse($formatted);
    }

//ajouter événement pour le resp jardin

    /**
     * @Route("/ajoutevent/{idj}/{titre}/{description}/{date}/{idc}", name="ajouteve_api",methods={"GET"})

     */

    public function AjoutereventAction(Request $request, $idj, $titre, $description,$date,$idc)
    {
        $ev = new Evenement();
        $ev->setJardin($this->getDoctrine()->getManager()->getRepository(Jardin::class)->find($idj));
        $ev->setCategorie($this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($idc));

        $ev->setDate(New \DateTime($date));

        $ev->setTitre($titre);
        $ev->setDescription($description);
        //$ev->setImage($image);


        $ex = "succes";
        $em = $this->getDoctrine()->getManager();
        $em->persist($ev);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }


    //supprimer un événement pour resp jardin

    /**
     *
     *
     * @Route("/suppevent/{id}", name="suppevenement_api")
     */
    public function supprimereventAction($id)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($em->getRepository(Evenement::class)->find($id));
            $em->flush();
            return new JsonResponse(true);

        } catch (Exception $exception) {
            return new JsonResponse(false);
        }
    }


//modifier événement pour resp jardin

    /**
     * @Route("/editevent/{id}/{titre}/{description}/{date}", name="modeve")
     */

    public function ModifierevefAction(Request $request, $id, $titre, $description, $date)
    {
        $evenement = $this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id);

        $evenement->setTitre($titre);
        $evenement->setDescription($description);
        $evenement->setDate(New \DateTime($date));


        $ex = "succes";
        $em = $this->getDoctrine()->getManager();

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }

// supprimer catégorie
    /**
     *
     *
     * @Route("/suppcat/{id}", name="suppcat_api")
     */
    public function supprimercatAction($id)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($em->getRepository(Categorie::class)->find($id));
            $em->flush();
            return new JsonResponse(true);

        } catch (Exception $exception) {
            return new JsonResponse(false);
        }
    }

//Ajouter catégorie

    /**
     * @Route("/ajoutercat/{libelle}", name="ajouteve")
     * @throws Exception
     */

    public function AjoutercatAction(Request $request, $libelle)
    {
        $ca = new Categorie();
        //$ca->setJardin($this->getDoctrine()->getManager()->getRepository(Jardin::class)->find($idj));

        $ca->setLibelle($libelle);

        $ex = "succes";
        $em = $this->getDoctrine()->getManager();
        $em->persist($ca);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }


//participer
    /**
     * @Route("/participerevent/{ide}/{idev}", name="parteve")
     * @throws Exception
     */

    public function ParticiperAction(Request $request, $ide,$idev)
    {
        $part = new Participer();

        $part->setEnfant($this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($ide));
        $part->setEvenement($this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($idev));

        $evp = "succes";

        $em = $this->getDoctrine()->getManager();
        $em->persist($part);
        $em->flush();


    }



    }


