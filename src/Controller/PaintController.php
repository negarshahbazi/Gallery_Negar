<?php

namespace App\Controller;

use App\Entity\Paint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


class PaintController extends AbstractController
{
    #[Route('/paint/{id}', name: 'app_paint')]
    public function index(Paint $paint): Response
    {
        return $this->render('paint/index.html.twig', [
            'paint' => $paint,
        ]);
    }
    #[Route('/paint/{id}/rate/{grade}', name: 'app_rate_paint')]
    public function ratePaint(Paint $paint,string $grade, EntityManagerInterface $entityManager): RedirectResponse
    {
        $grade = (int)$grade;

        // Mettre à jour les informations de la peinture
        $newGradeCount = $paint->getGradeCount() + 1;
        $paint->setGradeCount($newGradeCount);

        // Calculer le nouveau grade total en utilisant la méthode de l'entité
        $newGradeTotal = $paint->getGradeTotal()+ $grade;
        $paint->setGradeTotal($newGradeTotal);

        // Enregistrer les modifications dans la base de données
        $entityManager->persist($paint);
        $entityManager->flush();

        // Rediriger vers la page de détails de la peinture
        return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
    }
}
