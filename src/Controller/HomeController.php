<?php

namespace App\Controller;

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

        $paintRepository = $this->entityManager->getRepository(Paint::class);
        $paints = $paintRepository->findAll(); // Supposons que l'ID de la peinture soit 1
        foreach ($paints as $paint) {
            // Récupérer gradeCount et gradeTotal de la peinture
            $title = $paint->getTitle();
            $photo = $paint->getPhoto();
            $sizeW = $paint->getSizeW();
            $sizeH = $paint->getSizeH();
            $sizeD = $paint->getSizeD();
            $price = $paint->getPrice();
            $typeOfWork = $paint->getTypeOfWork();
            $category = $paint->getCategory();
            $status = $paint->getStatus();
            $gradeCount = $paint->getGradeCount();
            $gradeTotal = $paint->getGradeTotal();
        }


        return $this->render('home/index.html.twig', [
            'title' => $title,
            'photo' => $photo,
            'sizeW' => $sizeW,
            'sizeH' => $sizeH,
            'sizeD' => $sizeD,
            'price' => $price,
            'typeOfWork' => $typeOfWork,
            'category' => $category,
            'status' => $status,
            'gradeCount' => $gradeCount,
            'gradeTotal' => $gradeTotal,

        ]);
    }
}
