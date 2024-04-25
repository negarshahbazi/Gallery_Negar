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
    {    $paints = $this->entityManager->getRepository(Paint::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        $panier = new Panier();
        $user = $this->getUser();
        
      
        
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
       
            $panier = $form->getData();
              // Gérer le changement du compteur du panier
              $panierCount = $panier->getPanierCount();
              if ($panierCount === 1) {
                  $panier->setPanierCount(0);
              } else {
                  $panier->setPanierCount(1);
              }
            $panier->setPanierCount(1);
        
        
       

            

            $entityManager->persist($panier);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'panier' => $panier,
            'user' => $user,
            'form' => $form->createView(),
            'paints' => $paints,
            'categories'=> $categories
            
        ]);
    }
}
