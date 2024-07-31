<?php 

namespace App\Controller;

use App\Entity\Etoile;
use App\Entity\Messages;
use App\Entity\Paint;
use App\Entity\Stars;
use App\Form\MessagesType;
use App\Repository\EtoileRepository;
use App\Repository\MessagesRepository;
use App\Repository\StarsRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaintController extends AbstractController
{
    #[Route('/paint/{id}', name: 'app_paint')]
    public function index(Paint $paint, Request $request, MessagesRepository $messagesRepository, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $user = $this->getUser();
        $alreadyCommented = false;

        // Rechercher les messages existants sur cette peinture
        $messages = $messagesRepository->findBy(['paint' => $paint], ['id' => 'DESC']);

        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        $panierCount = $session->get('panierCount', 0);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                // Stocker le message d'alerte dans la session
                $this->addFlash('info', '⚡ You must be logged in to submit a comment.');
                return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
            }
           
                $date = new DateTimeImmutable();
                $message->setCreatedAt($date);
                $message->setPaint($paint);
                $message->setUser($user);

                $entityManager->persist($message);
                $entityManager->flush();
                $this->addFlash('succes', '✅ Your comment has been submitted.');

                return $this->redirectToRoute('app_paint', ['id' => $paint->getId()], Response::HTTP_SEE_OTHER);
            
        }

        return $this->render('paint/index.html.twig', [
            'message' => $message,
            'panierCount' => $panierCount,
            'paint' => $paint, // Passer la variable paint au template
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'alreadyCommented' => $alreadyCommented,
            'messages' => $messages,
        ]);
    }

    #[Route('/paint/{id}/rate/{grade}', name: 'app_rate_paint')]
    public function ratePaint(Paint $paint, int $grade, EntityManagerInterface $entityManager, StarsRepository $starsRepository, SessionInterface $session): RedirectResponse
    {
        // Vérifier si l'utilisateur est authentifié
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('warning', '⚡ You must be logged in to submit a rating.');
            return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
        }
    
        // Vérifier si l'utilisateur a déjà noté cette peinture
        $alreadyNote = false;
        $existingEtoile = $starsRepository->findOneBy([
            'paint' => $paint,
            'user' => $user
        ]);
    
        if ($existingEtoile) {
            $this->addFlash('warning', ' ⚠️ You have already rated this painting.');
            $alreadyNote = true;
        } else {
            $etoile = new Stars();
            $etoile->setPaint($paint);
            $etoile->setUser($user);
            $etoile->setGradeCount(1);
            $etoile->setGradeTotal($grade);
    
            // Mettre à jour les informations de la peinture
            $newGradeCount = $paint->getGradeCount() + 1;
            $paint->setGradeCount($newGradeCount);
    
            // Calculer le nouveau grade total en utilisant la méthode de l'entité
            $newGradeTotal = $paint->getGradeTotal() + $grade;
            $paint->setGradeTotal($newGradeTotal);
    
            // Enregistrer les modifications dans la base de données
            $entityManager->persist($paint);
            $entityManager->persist($etoile);
            $entityManager->flush();
    
            $this->addFlash('success', '✅ Your rating has been submitted.');
        }
    
        // Calculer la note moyenne et la stocker dans la session
        $averageGrade = $paint->getGradeCount() > 0 ? $paint->getGradeTotal() / $paint->getGradeCount() : 0;
        $session->set('note', $averageGrade);
    
        return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
    }
    
}
