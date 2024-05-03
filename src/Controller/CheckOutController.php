<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CheckOutController extends AbstractController
{
    #[Route('/check/out', name: 'app_check_out')]
    public function index(SessionInterface $session): Response
    {
        $panierCount = $session->get('panierCount', 0);

        $user = $this->getUser();
        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        return $this->render('check_out/index.html.twig', [
            'controller_name' => 'CheckOutController',
            'panierCount' => $panierCount,
            'user' => $user,
        ]);
    }
}
