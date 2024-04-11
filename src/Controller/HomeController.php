<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Paint;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        // Récupérer les informations sur la peinture depuis la base de données

        $paints = $this->entityManager->getRepository(Paint::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();



        return $this->render('home/index.html.twig', [
       'paints' => $paints,
       'categories'=> $categories
        ]);
    }
}
