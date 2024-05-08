<?php

namespace App\Controller;

use App\Repository\PaintRepository;
use App\Repository\PanierRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, PanierRepository $panierRepository, PaintRepository $paintRepository, PhotoRepository $photoRepository): Response
    {
        $panierCount = $session->get('panierCount', 0);
        $user = $this->getUser();
        if (!$user) {
            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
        $panierItems = $panierRepository->findBy(['user' => $user]);
        $paintDetails = [];
        $totalPrice = 0;
        foreach ($panierItems as $item) {
            $paintId = $item->getPaint();
            $paints = $paintRepository->findBy(['id' => $paintId]);
            foreach ($paints as $paint) {
                $paintDetails[] = $paint;
                $totalPrice += $paint->getPrice();
            }
        }
        // Stocker le totalPrice dans la session
        $session->set('totalPrice', $totalPrice);

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'panierCount' => $panierCount,
            'paints' => $paintDetails,
            'totalPrice' => $totalPrice,


        ]);
    }
}
