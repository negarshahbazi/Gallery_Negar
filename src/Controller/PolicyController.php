<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PolicyController extends AbstractController
{
    #[Route('/policy', name: 'app_policy')]
    public function index(SessionInterface $session): Response
    {    $panierCount = $session->get('panierCount', 0);
        return $this->render('policy/index.html.twig', [
            'controller_name' => 'PolicyController',
            'panierCount' => $panierCount
        ]);
    }
}
