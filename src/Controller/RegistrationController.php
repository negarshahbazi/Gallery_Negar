<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $registrationForm = $this->createForm(RegistrationFormType::class, $user);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $registrationForm->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Send an email
            $email = (new Email())
                ->from('negar.shahbazi70@gmail.com')
                ->to($user->getEmail())
                ->subject('Welcome to Negar Gallery!')
                ->html('<h2>Congratulations, your account has been created!</h2>');

            $mailer->send($email);

            // Redirect to profile form after successful registration
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $registrationForm->createView(),
        ]);
    }

}
