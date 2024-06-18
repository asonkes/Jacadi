<?php

namespace App\Security\Voter;

use App\Entity\Users;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UsersVoter extends Voter
{
    const EDIT = 'USER_EDIT';
    const DELETE = 'USER_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $user): bool
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$user instanceof Users) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $user, TokenInterface $token): bool
    {
        // On récupère l'utilisateur à partir du token
        $currentUser = $token->getUser();

        // On vérifie si l'utilisateur est connecté
        if (!$currentUser instanceof UserInterface) {
            // Si l'utilisateur n'est pas connecté, on retourne "false"
            return false;
        }

        // On vérifie si l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN')) return true;

        // On vérifie si l'utilisateur est connecté mais pas admin
        switch ($attribute) {
            case self::EDIT:
                // On vérifie si l'utilisateur peut éditer
                return $this->canEdit($currentUser, $user);
            case self::DELETE:
                // On vérifie si l'utilisateur peut supprimer
                return $this->canDelete($currentUser, $user);
        }

        return false;
    }

    private function canEdit(UserInterface $currentUser, Users $user): bool
    {
        // Ajoutez ici votre logique pour vérifier si l'utilisateur actuel peut éditer l'utilisateur cible
        return $currentUser === $user;
    }

    private function canDelete(UserInterface $currentUser, Users $user): bool
    {
        // Ajoutez ici votre logique pour vérifier si l'utilisateur actuel peut supprimer l'utilisateur cible
        return $currentUser === $user;
    }
}
