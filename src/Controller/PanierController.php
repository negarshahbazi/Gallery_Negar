<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Paint;
use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{

    #[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }



    #[Route('/{id}', name: 'app_panier_new')]
    public function myPanier(Paint $paint, EntityManagerInterface $entityManager, PanierRepository $panierRepository): Response
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
    
    #[Route('/cart/{id}', name: 'app_panier_cart')]
    public function myCart(Paint $paint, EntityManagerInterface $entityManager, PanierRepository $panierRepository): Response
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
    
        return $this->redirectToRoute('app_home_cart');
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

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $panier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }
}
