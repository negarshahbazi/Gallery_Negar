<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/edit/{id}', name: 'app_user_edit', methods: ['POST'])]
    public function editUserInfo(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {  $panierCount = $session->get('panierCount', 0);

        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_check_out', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
            'panierCount' => $panierCount, // Fixed syntax error by replacing semicolon with comma
        ]);
    }
}
