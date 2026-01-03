<!-- src/verifMDP.php -->

<?php
// Vérifie la robustesse d'un mot de passe

// Règles :
// - Minimum 12 caractères
// - 1 majuscule
// - 1 minuscule
// - 1 chiffre
// - 1 caractère spécial

function verifierMotDePasse(string $mdp): array
{
    if (strlen($mdp) < 12) {
        return ['valide' => false, 'message' => 'Le mot de passe doit contenir au moins 12 caractères.'];
    }

    if (!preg_match('/[A-Z]/', $mdp)) {
        return ['valide' => false, 'message' => 'Le mot de passe doit contenir au moins une majuscule.'];
    }

    if (!preg_match('/[a-z]/', $mdp)) {
        return ['valide' => false, 'message' => 'Le mot de passe doit contenir au moins une minuscule.'];
    }

    if (!preg_match('/[0-9]/', $mdp)) {
        return ['valide' => false, 'message' => 'Le mot de passe doit contenir au moins un chiffre.'];
    }

    if (!preg_match('/[\W_]/', $mdp)) {
        return ['valide' => false, 'message' => 'Le mot de passe doit contenir au moins un caractère spécial.'];
    }

    return ['valide' => true, 'message' => 'Mot de passe valide'];
}
