<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UsersFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
#[IsGranted('ROLE_ADMIN')]
class UsersController extends AbstractController
{
    #[Route('/utilisateurs', name: 'users')]
    public function index(UsersRepository $usersRepository): Response
    {
        // Permet de pouvoir récupérer tous les utilisateurs de la base de données
        $users = $usersRepository->findBy([], ['firstname' => 'asc']);
        return $this->render('admin/users/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/utilisateurs/edition/{id}', name: 'edit_user')]
    public function edit(Users $user, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        // Vérifie si l'utilisateur peut éditer avec le voter
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        // Crée le formulaire
        $userForm = $this->createForm(UsersFormType::class, $user);

        // Traite la requête du formulaire
        $userForm->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // Sauvegarde les modifications
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succès');

            // Redirige vers la liste des utilisateurs
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/users/edit.html.twig', [
            'userForm' => $userForm->createView(),
            'user' => $user
        ]);
    }

    #[Route('/utilisateurs/suppression/{id}', name: 'delete_user', methods: ['GET', 'POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManagerInterface): Response
    {
        // On vérifie si l'utilisateur peut delete avec le voter
        $this->denyAccessUnlessGranted('USER_DELETE', $user);

        // Vérifie le token CSRF pour sécuriser la requête de suppression
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->query->get('_token'))) {

            // Supprime l'utilisateur
            $entityManagerInterface->remove($user);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Utilisateur supprimé avec succès');
        } else {
            $this->addFlash('error', 'Le jeton CSRF est invalide.');
        }

        // Redirige vers la liste des utilisateurs
        return $this->redirectToRoute('admin_users');
    }
}
