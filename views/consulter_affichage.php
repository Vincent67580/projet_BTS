<!-- views/consulter_affichage.php -->

<?php
$pageCSS = 'consulter.css';
// Récupération des PJ associées
$stmtPJ = $pdo->prepare("
    SELECT pj.nomFichier, pj.cheminFichier
    FROM PieceJointe pj
    JOIN AjouterPJ ap ON ap.idPJ = pj.idPJ
    JOIN Signalements si ON si.idSignalement = ap.idSignalement
    WHERE si.numeroDossier = ?
");
$stmtPJ->execute([$signalement['numeroDossier']]);
$piecesJointes = $stmtPJ->fetchAll();
?>

<style>
.affichage-container {
    width: 60%;
    margin: 40px auto;
    padding: 25px;
    background: #f8f8f8;
    border-radius: 8px;
    box-shadow: 0 0 10px #0002;
}

.affichage-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.affichage-container p {
    font-size: 16px;
    margin: 10px 0;
}

.affichage-container p strong {
    display: inline-block;
    width: 120px;
}

.pj-list {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.pj-list img {
    max-width: 150px;
    border-radius: 6px;
    box-shadow: 0 0 5px #0003;
}

.btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background: #0069d9;
}

</style>


<div class="affichage-container">
    <h2>Signalement n° <?= htmlspecialchars($signalement['numeroDossier']) ?></h2>

    <?php if ($signalement['estAnonyme'] == 0): ?>
        <p><strong>Nom :</strong> <?= htmlspecialchars($signalement['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($signalement['prenom']) ?></p>
    <?php else: ?>
        <p><em>Ce signalement a été déposé anonymement.</em></p>
    <?php endif; ?>

    <p><strong>Type :</strong> <?= htmlspecialchars($signalement['libelleType']) ?></p>
    <p><strong>Description :</strong> <br> <?= nl2br(htmlspecialchars($signalement['contenu'])) ?></p>
    <p><strong>Status :</strong> <?= htmlspecialchars($signalement['libelleStatus']) ?></p>
    <p><strong>Date dépôt :</strong> <?= htmlspecialchars($signalement['dateDepot']) ?></p>

    <?php if (!empty($piecesJointes)): ?>
        <h3>Pièces jointes :</h3>
        <ul class="pj-list">
            <?php foreach ($piecesJointes as $pj): ?>
                <a href="../public/<?= htmlspecialchars($pj['cheminFichier']) ?>" target="_blank">
                    <img src="../public/<?= htmlspecialchars($pj['cheminFichier']) ?>" alt="">
                </a>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <a class = "btn" href="index.php">Retour à l'accueil</a>
</div>
