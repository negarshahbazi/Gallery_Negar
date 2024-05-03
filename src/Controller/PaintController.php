<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Paint;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use App\Repository\PanierRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaintController extends AbstractController
{
    #[Route('/paint/{id}', name: 'app_paint')]
    public function index(Paint $paint, Request $request,MessagesRepository $messagesRepository, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {   $message = new Messages();
        // Vérifier si l'utilisateur a déjà commenté cette peinture
        $user = $this->getUser();
        $alreadyCommented = false;
        //   dd($user);
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        $panierCount = $session->get('panierCount', 0);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                // Stocker le message d'alerte dans la session
                $this->addFlash('warning', 'You must be logged to submit an application');// Rediriger vers la page de la peinture avec un paramètre pour afficher l'alerte
                return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
            }
            // Rechercher un message existant de cet utilisateur sur cette peinture
            $existingMessage = $messagesRepository->findOneBy([
                'paint' => $paint,
                'user' => $user
            ]);
            if ($existingMessage) {
                $this->addFlash('info', 'You have already commented on this painting.');
                $alreadyCommented = true;
            } else {
                $date = new DateTimeImmutable();
                $message->setCreatedAt($date);
                $message->setPaint($paint);
                $message->setUser($user);

                $entityManager->persist($message);
                $entityManager->flush();

                return $this->redirectToRoute('app_paint', ['id' => $paint->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('paint/index.html.twig', [
            'message' => $message,
            'panierCount' => $panierCount,
            'paint' => $paint, // Passer la variable paint au template
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'alreadyCommented' => $alreadyCommented
        ]);
    }

    // pour étoile dans la page paints
    #[Route('/paint/{id}/rate/{grade}', name: 'app_rate_paint')]
    public function ratePaint(Paint $paint, string $grade, EntityManagerInterface $entityManager): RedirectResponse
    {    // Vérifier si l'utilisateur est authentifié
        $user = $this->getUser();
        if (!$user) {
            // Stocker le message d'alerte dans la session
            $this->addFlash('failed', 'You must be logged to submit an application'); // Rediriger vers la page de la peinture avec un paramètre pour afficher l'alerte
            return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
        }
        // Vérifier si l'utilisateur a déjà noté cette peinture

        $grade = (int)$grade;

        // Mettre à jour les informations de la peinture
        $newGradeCount = $paint->getGradeCount() + 1;
        $paint->setGradeCount($newGradeCount);

        // Calculer le nouveau grade total en utilisant la méthode de l'entité
        $newGradeTotal = $paint->getGradeTotal() + $grade;
        $paint->setGradeTotal($newGradeTotal);

        // Enregistrer les modifications dans la base de données
        $entityManager->persist($paint);
        $entityManager->flush();


        // Rediriger vers la page de détails de la peinture
        return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
    }
}
