<!-- public/depot.php -->

<?php
include __DIR__ . '/../views/layout/header.php';
require_once __DIR__ . '/../src/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pdo = get_pdo();

    // Génération numéro dossier unique YYMMDD + 8 chiffres aléatoires
    $datePart = date("ymd");
    do {
        $randomPart = str_pad(random_int(0, 99999999), 8, "0", STR_PAD_LEFT);
        $numeroDossier = $datePart . $randomPart;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM signalements WHERE numeroDossier = ?");
        $stmt->execute([$numeroDossier]);
        $exists = $stmt->fetchColumn();
    } while ($exists > 0);

    // Génération mot de passe aléatoire
    $motDePasse = bin2hex(random_bytes(4)); // 8 caractères

    // Vérification anonymat
    $estAnonyme = isset($_POST['estAnonyme']) ? 1 : 0;

    $nom = $estAnonyme ? null : $_POST['nom'];
    $prenom = $estAnonyme ? null : $_POST['prenom'];

    $stmt = $pdo->prepare("
        INSERT INTO signalements (
            typeSignalement, description, status, estAnonyme, nom, prenom, numeroDossier, motDePasse
        ) VALUES (
            :typeSignalement, :description, 'Nouveau', :estAnonyme, :nom, :prenom, :numeroDossier, :motDePasse
        )
    ");

    $stmt->execute([
        ':typeSignalement' => $_POST['typeSignalement'],
        ':description'     => $_POST['description'],
        ':estAnonyme'      => $estAnonyme,
        ':nom'             => $nom,
        ':prenom'          => $prenom,
        ':numeroDossier'   => $numeroDossier,
        ':motDePasse'      => password_hash($motDePasse, PASSWORD_BCRYPT)
    ]);

    echo "<h3 style='color:green'>Alerte enregistrée avec succès !</h3>";
    echo "<p>Votre numéro de dossier : <strong>$numeroDossier</strong></p>";
    echo "<p>Votre mot de passe : <strong>$motDePasse</strong></p>";
    echo "<p>Conservez ces informations pour suivre votre dossier.</p>";
}

include __DIR__ . '/../views/depot_alerte.php';
?>

<a href='index.php'>Retour</a>
