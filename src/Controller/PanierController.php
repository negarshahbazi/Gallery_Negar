<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Paint;
use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\MessagesRepository;
use App\Repository\PaintRepository;
use App\Repository\PanierRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{

    #[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(SessionInterface $session, PanierRepository $panierRepository, PaintRepository $paintRepository, PhotoRepository $photoRepository): Response
    {
        $panierCount = $session->get('panierCount', 0);
        if ($panierCount === 0) {
            $this->addFlash('notice', '📢Your cart is empty.');
        }
        $user = $this->getUser();
        if (!$user) {
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

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'CartController',
            'panierCount' => $panierCount,
            'paints' => $paintDetails,
            'totalPrice' => $totalPrice,


        ]);
    }



    #[Route('/{id}', name: 'app_panier_new')]
    public function myPanier(Paint $paint, EntityManagerInterface $entityManager, PanierRepository $panierRepository, MessagesRepository $messagesRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $existingPanier = $panierRepository->findOneBy(['user' => $user, 'paint' => $paint]);
        if ($existingPanier) {
            $entityManager->remove($existingPanier);
            $entityManager->flush();
        } else {
            $newPanier = new Panier();
            $newPanier->setPaint($paint);
            $newPanier->setUser($user);
            $newPanier->setPanierCount(1);


            $entityManager->persist($newPanier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home');
    }


    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }
    #[Route('/cart/{id}', name: 'app_panier_delete')]
    public function myCart(Paint $paint, EntityManagerInterface $entityManager, PanierRepository $panierRepository, SessionInterface $session): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $existingPanier = $panierRepository->findOneBy(['user' => $user, 'paint' => $paint]);
        if ($existingPanier) {
            $session->set('panierCount', $session->get('panierCount') - 1);

            $entityManager->remove($existingPanier);
            $entityManager->flush();
        } else {
            echo "panier not found";
        }
    
        return $this->redirectToRoute('app_panier_index');
    }
}
