<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ville;

class VilleController extends AbstractController
{
    /**
     * @Route("/insertVille/{nom}/{codepostal}", 
     * name="insertVille",requirements={"nom"="[a-z]{4,30}","codepostal"="[a-z]{4,30}"})    
     */

    public function insert(Request $request, $nom, $codepostal)
    {
        $vil = new Ville();
        $vil->setNom($nom);
        $vil->setCodepostal($codepostal);

        if ($request->isMethod('get')) { //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($vil); //insertion en bdd
            $em->flush();
            $resultat = ["ok"];
        } else {
            $resultat = ["nok"];
        }
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/ville", name="ville")
     */
    public function ville(Request $request)
    { //recuperation du repository grace au manager
        $em = $this->getDoctrine()->getManager();
        $villeRepository = $em->getRepository(Ville::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVilles = $villeRepository->findAll();
        $resultat = [];
        foreach ($listeVilles as $vil) {
            array_push($resultat, $vil->getNom(), $vil->getCodepostal());
        }
        $reponse = new JsonResponse($resultat);


        return $reponse;
    }


    /**
     * @Route("/deleteVille/{id}", 
     * name="deleteVille",requirements={"id"="[0-9]{1,5}"})    
     */

    public function delete(Request $request, $id)
    {
        //récupération du Manager  et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $villeRepository = $em->getRepository(Ville::class);
        //requete de selection
        $vil = $villeRepository->find($id);
        //suppression de l'entity
        $em->remove($vil);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
