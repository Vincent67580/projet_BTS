<!-- src/verifMDP.php -->

<?php

class verifMDP{
// Vérifie la robustesse d'un mot de passe

// Règles :
// - Minimum 12 caractères
// - 1 majuscule
// - 1 minuscule
// - 1 chiffre
// - 1 caractère spécial

function verifierMotDePasse(string $mdp): array
{
    $erreurs = []; // Tableau pour accumuler les erreurs
    if (strlen($mdp) < 12) {
        $erreurs[] = 'Le mot de passe doit contenir au moins 12 caractères.';
    }
    if (!preg_match('/[A-Z]/', $mdp)) {
        $erreurs[] = 'Le mot de passe doit contenir au moins une majuscule.';
    }
    if (!preg_match('/[a-z]/', $mdp)) {
        $erreurs[] = 'Le mot de passe doit contenir au moins une minuscule.';
    }
    if (!preg_match('/[0-9]/', $mdp)) {
        $erreurs[] = 'Le mot de passe doit contenir au moins un chiffre.';
    }
    if (!preg_match('/[\W_]/', $mdp)) {
        $erreurs[] = 'Le mot de passe doit contenir au moins un caractère spécial.';
    }
    // Si aucune erreur => valide
    if (empty($erreurs)) {
        return ['valide' => true, 'messages' => []];
    }
    // Sinon on retourne toutes les erreurs
    return ['valide' => false, 'messages' => $erreurs];
}

}