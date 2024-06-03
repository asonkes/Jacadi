<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt, UsersRepository $usersRepository): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encoder le mot de passe en clair
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // On génère le JWT de l'utilisateur
            // On créé le Header
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];

            // On créé le Payload
            $payload = [
                'user_id' => $user->getId()
            ];

            // On génère le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // Envoyer l'email d'activation
            $mail->send(
                'no-reply@monsite.net',
                $user->getEmail(),
                'Activation de votre compte sur Jacadi',
                'register',
                [
                    'user' => $user,
                    'token' => $token
                ]
            );

            return $security->login($user, UsersAuthenticator::class);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verification/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $em, LoggerInterface $logger): Response
    {
        $logger->info('Vérification du token commencée.');

        // Vérifier si le token est valide, n'a pas expiré, et n'a pas été modifié
        if ($jwt->isValid($token)) {
            $logger->info('Le token est valide.');
        } else {
            $logger->warning('Le token n\'est pas valide.');
        }

        if (!$jwt->isExpired($token)) {
            $logger->info('Le token n\'est pas expiré.');
        } else {
            $logger->warning('Le token est expiré.');
        }

        if ($jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            $logger->info('Le token est authentique.');
        } else {
            $logger->warning('Le token n\'est pas authentique.');
        }

        if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            // Récupérer le payload
            $payload = $jwt->getPayload($token);
            $logger->info('Payload récupéré: ' . json_encode($payload));

            // Récupérer l'utilisateur à partir du token
            $user = $usersRepository->find($payload['user_id']); // Utiliser 'user_id' comme dans le payload

            // Vérifier si l'utilisateur existe et n'a pas encore activé son compte
            if ($user) {
                $logger->info('Utilisateur trouvé: ' . $user->getEmail());
                if (!$user->getIsVerified()) {
                    $user->setIsVerified(true);
                    $em->flush();
                    $logger->info('Utilisateur activé.');

                    $this->addFlash('success', 'Utilisateur activé');
                    return $this->redirectToRoute('home');
                } else {
                    $logger->info('Utilisateur déjà activé.');
                }
            } else {
                $logger->warning('Utilisateur non trouvé pour le token donné.');
            }
        } else {
            $logger->warning('Token invalide ou expiré.');
        }

        // Gérer les problèmes de token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UsersRepository $usersRepository)
    {
        // Récupérer le "user connecté"
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getIsVerified()) {
            $this->addFlash('Warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('app_login');
        }

        // Générer le JWT de l'utilisateur
        // On créé le header
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        // On créé le Payload
        $payload = [
            'user_id' => $user->getId()
        ];

        // On génère le token
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        // Envoyer l'email d'activation
        $mail->send(
            'no-reply@monsite.net',
            $user->getEmail(),
            'Activation de votre compte sur Jacadi',
            'register',
            [
                'user' => $user,
                'token' => $token
            ]
        );

        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('home');
    }
}
