<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Paint;
use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PaintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_home')]
    public function panier(Request $request, EntityManagerInterface $entityManager, PaintRepository $paintRepository): Response
    {  // Initialiser tous les compteurs à zéro
        $panierCount = 0;

        $paints = $this->entityManager->getRepository(Paint::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

   
        $user = $this->getUser();
        $panier = $entityManager->getRepository(Panier::class)->findOneBy(['user' => $user]);
        if (!$panier) {
            $panier = new Panier();
            $panier->setUser($user);
            $panier->setPanierCount(0); // Initialiser le panier à 0 s'il n'existe pas encore
            $entityManager->persist($panier);
            $entityManager->flush();
        }
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panier = $form->getData();
            
            if ($panierCount === 1) {
                // Si le panier a déjà été ajouté, supprimez-le
                $panier->setPanierCount(0);
                $entityManager->remove($panier);
                $entityManager->flush();
                $panierCount = $panier->getPanierCount();
            } else {
                // Sinon, créez une nouvelle entrée dans le panier
                $newPanier = new Panier();
                $newPanier->setUser($user);
                $newPanier->setPanierCount(1);
                $panierCount = $panier->getPanierCount();
                // Ajoutez d'autres champs si nécessaire
                $entityManager->persist($newPanier);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'panier' => $panier,
            'panierCount' => $panierCount,
            'user' => $user,
            'form' => $form->createView(),
            'paints' => $paints,
            'categories' => $categories

        ]);
    }
}
