<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/insertUser/{nom}", 
     * name="insertUser",requirements={"nom"="[a-z]{4,30}"})    
     */

    public function insert(Request $request, $username, $password)
    {
        $u = new User();
        $u->setUsername($username);
        $u->getPassword($password);

        if ($request->isMethod('get')) { //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($u); //insertion en bdd
            $em->flush();
            $resultat = ["ok"];
        } else {
            $resultat = ["nok"];
        }
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/user", name="user")
     */
    public function user(Request $request)
    { //recuperation du repository grace au manager
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeUsers = $userRepository->findAll();
        $resultat = [];
        foreach ($listeUsers as $u) {
            array_push($resultat, $u->getUserName());
        }
        $reponse = new JsonResponse($resultat);


        return $reponse;
    }


    /**
     * @Route("/deleteUser/{id}", 
     * name="deleteUser",requirements={"id"="[0-9]{1,5}"})    
     */

    public function delete(Request $request, $id)
    {
        //récupération du Manager  et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);
        //requete de selection
        $u = $userRepository->find($id);
        //suppression de l'entity
        $em->remove($u);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
