<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trajet;

class TrajetController extends AbstractController
{
    /**
     * @Route("/insertTrajet/{personne}/{ville_dep}/{ville_arr}/{nbKms}/{DateTrajet}", 
     * name="insertTrajet")    
     */

    public function insert(Request $request, $personne, $ville_dep, $ville_arr, $nbKms, $DateTrajet)
    {
        $traj = new Trajet();
        $traj->addPersonne($personne);
        $traj->setVilleDep($ville_dep);
        $traj->setVilleArr($ville_arr);
        $traj->setNbKms($nbKms);
        $traj->setDateTrajet($DateTrajet);

        if ($request->isMethod('get')) { //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($traj); //insertion en bdd
            $em->flush();
            $resultat = ["ok"];
        } else {
            $resultat = ["nok"];
        }
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/trajet", name="trajet")
     */
    public function liste(Request $request)
    { //recuperation du repository grace au manager
        $em = $this->getDoctrine()->getManager();
        $trajetRepository = $em->getRepository(Trajet::class);
        //trajetRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeTrajets = $trajetRepository->findAll();
        $resultat = [];
        foreach ($listeTrajets as $traj) {
            array_push($resultat, $traj->getPersonne(), $traj->getVilleDep(), $traj->getVilleArr(), $traj->getNbKms(), $traj->getDateTrajet());
        }
        $reponse = new JsonResponse($resultat);


        return $reponse;
    }

        /**
     * @Route("/deleteTrajet/{id}", 
     * name="deleteTrajet",requirements={"id"="[0-9]{1,5}"})    
     */

    public function delete(Request $request, $id)
    {
        //récupération du Manager  et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $trajetRepository = $em->getRepository(Trajet::class);
        //requete de selection
        $traj = $trajetRepository->find($id);
        //suppression de l'entity
        $em->remove($traj);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
