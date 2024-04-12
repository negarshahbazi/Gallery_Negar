<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Paint;
use App\Entity\User;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/messages')]
class MessagesController extends AbstractController
{
    #[Route('/', name: 'app_messages_index', methods: ['GET'])]
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('paint/index.html.twig', [
            'messages' => $messagesRepository->findAll(),
        ]);
    }
// ********************************//
    // #[Route('/new/{id}', name: 'app_messages_new', methods: ['GET', 'POST'])]
    // public function new(Paint $paint,Request $request, EntityManagerInterface $entityManager): Response
    // {  // Vérifier si l'utilisateur est authentifié
    //     $user = $this->getUser();
    //     if (!$user) {
    //         // Stocker le message d'alerte dans la session
    //         $this->addFlash('warning', 'You must be logged to submit an application');            // Rediriger vers la page de la peinture avec un paramètre pour afficher l'alerte
    //         return $this->redirectToRoute('app_paint', ['id' => $paint->getId()]);
    //     }
        
    //     $message = new Messages();

    //     $form = $this->createForm(MessagesType::class, $message);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
            
    //         $date=new DateTimeImmutable();
    //         $message->setCreatedAt($date);
    //         $message->setPaint($paint);
    //         dd($user);
    //         $message->setUser($user);
    //         $entityManager->persist($message);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_paint', ['id' => $paint->getId()], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('paint/index.html.twig', [
    //         'message' => $message,
    //         'user' =>$user,
    //         'paint' => $paint, // Passer la variable paint au template
    //         'form' => $form->createView(),
    //     ]);
    // }

    #[Route('/{id}', name: 'app_messages_show', methods: ['GET'])]
    public function show(Messages $message): Response
    {
        return $this->render('messages/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_messages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Messages $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_messages_delete', methods: ['POST'])]
    public function delete(Request $request, Messages $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_messages_index', [], Response::HTTP_SEE_OTHER);
    }
}
