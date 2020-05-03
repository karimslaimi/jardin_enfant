<?php

namespace EmnaBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Jardin;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * WebServices controller.
 *
 * @Route("Api")
 */
class webservicesController extends Controller
{


    /**
     *@Route("/categories", name="categories_api")

     */

    public function categoriesAPiAction()
    {
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
     * @Route("/ajouteve/{idj}/{titre}/{description}/{idc}", name="ajouteve")
     * @throws Exception
     */

    public function AjoutereventAction(Request $request, $idj, $titre, $description,$idc)
    {
        $ev = new Evenement();
        $ev->setJardin($this->getDoctrine()->getManager()->getRepository(Jardin::class)->find($idj));
        $ev->setCategorie($this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($idc));

        $ev->setTitre($titre);
        $ev->setDescription($description);
        //$ev->setImage($image);
        $ev->setDate(New \DateTime());


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
        $evenement->setDate(New DateTime($date));


        $ex = "succes";
        $em = $this->getDoctrine()->getManager();

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }


    //liste des catégories pour le resp jardin


}


