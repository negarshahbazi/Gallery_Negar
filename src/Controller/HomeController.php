<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\PaintRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_home')]
    public function panier( PaintRepository $paintRepository, CategoryRepository $categoryRepository, PanierRepository $panierRepository, SessionInterface $session): Response
    {  // Initialiser tous les compteurs à zéro
       
       

        $paints = $paintRepository->findAll();
        $categories = $categoryRepository->findAll();

   
        $user = $this->getUser();
     
        $paniers = $panierRepository->findBy(['user' => $user]);

      
        $panierCount = 0;



        foreach ($paniers as $key => $value) {
            $panierCount += $value->getPanierCount();
        }

      // Stockage du nombre total d'articles dans la session
      $session->set('panierCount', $panierCount);
       
        return $this->render('home/index.html.twig', [
            'paniers' => $paniers,
            'panierCount' => $panierCount,
            'user' => $user,
            'paints' => $paints,
            'categories' => $categories

        ]);
    }

    #[Route('/cart', name: 'app_home_cart')]
    public function cart( PaintRepository $paintRepository, CategoryRepository $categoryRepository, PanierRepository $panierRepository, SessionInterface $session): Response
    {  // Initialiser tous les compteurs à zéro
       
        $paints = $paintRepository->findAll();
        $categories = $categoryRepository->findAll();

   
        $user = $this->getUser();
       

      // Stockage du nombre total d'articles dans la session
      $panierCount = $session->get('panierCount');
       
        return $this->render('cart/index.html.twig', [
            
            'panierCount' => $panierCount,
            'user' => $user,
            'paints' => $paints,
            'categories' => $categories

        ]);
    }
  
    #[Route('/paint/gallery', name: 'app_gallery')]
    public function gallery(PaintRepository $paintRepository,  SessionInterface $session, EntityManagerInterface $entityManager): Response
    {   
      $panierCount = $session->get('panierCount', 0);
      $paints = $paintRepository->findAll();
   


     
    
    return $this->render('home/gallery.html.twig', [
        'paints' => $paints,
        'panierCount' => $panierCount
    ]);
}

#[Route('/about', name: 'app_about')]
public function about( SessionInterface $session): Response
{   
  $panierCount = $session->get('panierCount', 0);

return $this->render('about/index.html.twig', [

    'panierCount' => $panierCount
]);
}
}
