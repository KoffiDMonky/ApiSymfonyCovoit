<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Voiture;

class VoitureController extends AbstractController
{
    /**
     * @Route("/insertVoiture/{marque}/{nb_places}/{modele}", 
     * name="insertVoiture",requirements={"marque"="[a-z]{4,30}","nb_places"="[a-z]{4,30}","modele"="[a-z]{4,30}"})    
     */

    public function insert(Request $request, $marque, $nb_places, $modele )
    {
        $voit = new Voiture();
        $voit->setMarque($marque);
        $voit->setNbPlaces($nb_places);
        $voit->setModele($modele);
        

        if ($request->isMethod('get')) { //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($voit); //insertion en bdd
            $em->flush();
            $resultat = ["ok"];
        } else {
            $resultat = ["nok"];
        }
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/voiture", name="voiture")
     */
    public function Voiture(Request $request)
    { //recuperation du repository grace au manager
        $em = $this->getDoctrine()->getManager();
        $VoitureRepository = $em->getRepository(Voiture::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVoitures = $VoitureRepository->findAll();
        $resultat = [];
        foreach ($listeVoitures as $voit) {
            array_push($resultat, $voit->getMarque(),$voit->getNbPlaces(),$voit->getModele());
        }
        $reponse = new JsonResponse($resultat);


        return $reponse;
    }


    /**
     * @Route("/deleteVoiture/{id}", 
     * name="deleteVoiture",requirements={"id"="[0-9]{1,5}"})    
     */

    public function delete(Request $request, $id)
    {
        //récupération du Manager  et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $VoitureRepository = $em->getRepository(Voiture::class);
        //requete de selection
        $voit = $VoitureRepository->find($id);
        //suppression de l'entity
        $em->remove($voit);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
