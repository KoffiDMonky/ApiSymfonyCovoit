<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListePersonneController extends AbstractController
{

    /**
     * @Route("/insertPersonne/{nom}/{prenom}/{dateNaiss}/{ville}/{tel}/{email}/{voiture}/{user}", 
     * name="insertPersonne",requirements={"nom"="[a-z]{4,30}"})    
     */

    public function insert(Request $request, $nom, $prenom, $dateNaiss, $ville, $tel, $email, $voiture, $user)
    {
        $pers = new Personne();
        $pers->setNom($nom);
        $pers->setPrenom($prenom);
        $pers->setDateNaiss($dateNaiss);
        $pers->setVille($ville);
        $pers->setTel($tel);
        $pers->setEmail($email);
        $pers->setVoiture($voiture);
        $pers->setUser($user);

        if ($request->isMethod('get')) { //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($pers); //insertion en bdd
            $em->flush();
            $resultat = ["ok"];
        } else {
            $resultat = ["nok"];
        }
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/personne", name="personne")
     */
    public function liste(Request $request)
    { //recuperation du repository grace au manager
        $em = $this->getDoctrine()->getManager();
        $personneRepository = $em->getRepository(Personne::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listePersonnes = $personneRepository->findAll();
        $resultat = [];
        foreach ($listePersonnes as $pers) {
            array_push($resultat, $pers->getNom(), $pers->getPrenom(), $pers->getDateNaiss(), $pers->getVille(), $pers->getTel(), $pers->getEmail(), $pers->getVoiture(),$pers->getUser());
        }
        $reponse = new JsonResponse($resultat);


        return $reponse;
    }

        /**
     * @Route("/deletePersonne/{id}", 
     * name="deletePersonne",requirements={"id"="[0-9]{1,5}"})    
     */

    public function delete(Request $request, $id)
    {
        //récupération du Manager  et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $personneRepository = $em->getRepository(Personne::class);
        //requete de selection
        $pers = $personneRepository->find($id);
        //suppression de l'entity
        $em->remove($pers);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }

}
