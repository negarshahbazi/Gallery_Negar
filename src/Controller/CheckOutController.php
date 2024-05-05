<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CheckOutController extends AbstractController
{
    #[Route('/check/out', name: 'app_check_out')]
    public function index(SessionInterface $session,Request $request, EntityManagerInterface $entityManager): Response
    {
        $panierCount = $session->get('panierCount', 0);

        $user = $this->getUser();
        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(UserType::class, $user);
           // Gérer la soumission du formulaire
           $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
               // Enregistrer les modifications de l'utilisateur
               $entityManager->flush();
               return $this->redirectToRoute('app_check_out');
            }

        return $this->render('check_out/index.html.twig', [
            'controller_name' => 'CheckOutController',
            'panierCount' => $panierCount,
            'user' => $user,
            'form' => $form->createView(), // Créer une vue du formulaire pour l'afficher dans le template

        ]);
    }
}
