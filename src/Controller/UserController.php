<?php

namespace App\Controller;

use Stripe\Stripe;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PayPalHttp\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Vérifier si l'utilisateur a le rôle 'ROLE_ADMIN'
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Si l'utilisateur n'a pas le rôle, lever une exception ou ajouter une alerte
            $this->addFlash('danger', 'Vous n\'avez pas la permission d\'accéder à cette page.');

            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $panierCount = $session->get('panierCount', 0);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'panierCount' => $panierCount
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, SessionInterface $session): Response
    {
        $panierCount = $session->get('panierCount', 0);
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'panierCount' => $panierCount
        ]);
    }
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $panierCount = $session->get('panierCount', 0);
        $totalPrice = $session->get('totalPrice', 0);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $methodPayment = $form->get('methodPayment')->getData();

            $user->setMethodPayment($methodPayment);

            $entityManager->persist($user);
            $entityManager->flush();

            if ($methodPayment === "stripe") {
                return $this->redirectToRoute('app_user_stripe');
            } else if ($methodPayment === 'paypal') {
                return $this->redirectToRoute('app_user_paypal');
            }

            return $this->redirectToRoute('app_user_edit', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'panierCount' => $panierCount,
            'totalPrice' => $totalPrice
        ]);
    }

    #[Route('/stripe/stripe_checkout', name: 'app_user_stripe', methods: ['GET', 'POST'])]
    public function stripe_checkout(SessionInterface $session): RedirectResponse
    {

        $totalPrice = $session->get('totalPrice', 0);

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $stripeKey = $_ENV['STRIPE_SECRET_KEY'];
        Stripe::setApiKey($stripeKey);

        $paymentIntent = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Gallery',
                        ],
                        'unit_amount' => $totalPrice * 100,
                    ],

                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ]);
        $url = $paymentIntent->url;

        return new RedirectResponse($url);
    }

    #[Route('/cancel', name: 'app_user_cancel', methods: ['GET'])]
    public function cancel(SessionInterface $session ): Response
    {   $panierCount = $session->get('panierCount', 0);
        $totalPrice = $session->get('totalPrice', 0);

        return $this->render('user/cancel.html.twig', [
            'panierCount' => $panierCount,
            'totalPrice' => $totalPrice
        ]);
    }

    #[Route('/success', name: 'app_user_success', methods: ['GET'])]
    public function success(SessionInterface $session): Response
    {   $panierCount = $session->get('panierCount', 0);
        $totalPrice = $session->get('totalPrice', 0);

        return $this->render('user/success.html.twig', [
            'panierCount' => $panierCount,
            'totalPrice' => $totalPrice
        ]);
    }

    #[Route('/paypal/paypal_checkout', name: 'app_user_paypal', methods: ['GET', 'POST'])]
    public function paypal_checkout(SessionInterface $session): RedirectResponse
    {
        $paypalClientId = $_ENV['PAYPAL_CLIENT_ID'];
        $paypalSecret = $_ENV['PAYPAL_SECRET'];
        $environment = new SandboxEnvironment($paypalClientId, $paypalSecret);
        $client = new PayPalHttpClient($environment);
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $totalPrice = $session->get('totalPrice', 0);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "EUR",
                    "value" =>  $totalPrice
                ]
            ]],
            'success_url' => $YOUR_DOMAIN . '/success',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ];
        try {
            $response = $client->execute($request);
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return $this->redirect($link->href);
                }
            }
        } catch (HttpException $ex) {
            dump($ex->statusCode);
            dump($ex->getMessage());
        }
    }


    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
