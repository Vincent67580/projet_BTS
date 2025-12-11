<!-- public/consulter.php -->
<?php
include __DIR__ . '/../views/layout/header.php';
require_once __DIR__ . '/../src/db.php';

$pdo = get_pdo();

// Si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $num = $_POST['numeroDossier'];
    $mdp = $_POST['motDePasse'];

    // Récupération du signalement correspondant
    $stmt = $pdo->prepare("SELECT * FROM signalements WHERE numeroDossier = ?");
    $stmt->execute([$num]);
    $signalement = $stmt->fetch();

    if ($signalement && password_verify($mdp, $signalement['motDePasse'])) {
        // OK , on affiche
        include __DIR__ . '/../views/consulter_affichage.php';
    } else {
        echo "<p style='color:red;'>Numéro de dossier ou mot de passe incorrect.</p>";
        include __DIR__ . '/../views/consulter_form.php';
    }

} else {
    // Première visite juste le formulaire
    include __DIR__ . '/../views/consulter_form.php';
}
?>

<a href="index.php">Retour</a>
