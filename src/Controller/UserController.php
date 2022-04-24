<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user/ajout", name="ajoutUser
     *",methods={"POST"})    
     */

    public function ajoutUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if ($request->isMethod('post')) {
            // On instancie un nouveau user
            $user = new User();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $user->setUsername($donnees->username);
            $user->setRoles($donnees->role);
            $user->setPassword($encoder->encodePassword($user,$donnees->password));
            $user->setApiToken($donnees->apiToken);

            // On sauvegarde en bdd
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        } else {
            return new Response('Failed', 404);
        }
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
            array_push($resultat, ["id"=>$u->getId(),"username"=>$u->getUserName(),"apiToken"=>$u->getApiToken()]);
        }
        $reponse = new JsonResponse($resultat);


        return $reponse;
    }


    /**
     * @Route("/user/suppr/{id}", 
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
