<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UsersRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Route qui va me permettre en donnant mon adresse mail de recevoir un lien
     *
     * @return Response
     */
    #[route(path: '/oubli-mot_de_passe', name: 'forgotten_password')]
    public function forgottenPassword(Request $request, UsersRepository $usersRepository, TokenGeneratorInterface $tokenGeneratorInterface, EntityManagerInterface $entityManagerInterface, SendMailService $mail): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        // Permet de récupérer les données ausinon les datas ne sont pas récupérées
        $form->handleRequest($request);

        // Permet de vérifier si le formulaire a été soumis(submitted) et valide(valid)
        if ($form->isSubmitted() && $form->isValid()) {

            // On va chercher l'utilisateur par son e-mail (je vais donc chercher les data dans le champ email de mon formulaire)
            $user = $usersRepository->findOneByEmail($form->get('email')->getData());

            // On vérifie si on a un utilisateur
            if ($user) {
                // On génère un token de réinitialisation 
                $token = $tokenGeneratorInterface->generateToken();
                $user->setResetToken($token);
                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();

                // On génère un lien de réinitialisation du mot de passe
                // generateUrl (fonctionnalité symfony de générer une url)
                $url = $this->generateUrl('reset_pass', [
                    'token' => $token
                ], UrlGeneratorInterface::ABSOLUTE_URL);

                // On créé les données du mail
                $context = [
                    'url' => $url,
                    'user' => $user
                ];

                // On envoie le mail
                $mail->send(
                    'no-reply@gmail.com',
                    $user->getEmail(),
                    'Réinitialisation du mot de passe',
                    'password_reset',
                    $context
                );

                $this->addFlash('success', 'Email envoyé avec succès');
                return $this->redirectToRoute('app_login');
            }
            // user est null
            $this->addFlash('warning', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');
        }

        // Fichier créé pour la demande du mot de passe
        return $this->render('security/reset_password_request.html.twig', [

            // tu me créé la vue de mon formulaire html et tu l'as passe sous la forme "requestPassForm"
            'requestPassForm' => $form->createView()
        ]);
    }

    /**
     * Route qui va me permettre en cliquant sur le lien de pouvoir choisir un autre mot de passe
     */
    #[Route(path: 'oubli-mot_de_passe/{token}', name: 'reset_pass')]
    public function resetPass(string $token, Request $request, UsersRepository $usersRepository, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        // On vérifie si on a ce token dans la base de données
        $user = $usersRepository->findOneByResetToken($token);

        if ($user) {
            $form = $this->createForm(ResetPasswordFormType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // On efface le token
                $user->setResetToken('');
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();

                $this->addFlash('success', 'Mot de passe changé avec succès');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger', 'jeton invalide');
        return $this->redirectToRoute('app_login');
    }
}
