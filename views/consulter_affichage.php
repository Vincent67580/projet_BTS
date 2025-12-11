<!-- views/consulter_affichage.php -->

<h2>Signalement n° <?= htmlspecialchars($signalement['numeroDossier']) ?></h2>

<p><strong>Type :</strong> <?= htmlspecialchars($signalement['typeSignalement']) ?></p>
<p><strong>Description :</strong> <?= nl2br(htmlspecialchars($signalement['description'])) ?></p>
<p><strong>Status :</strong> <?= htmlspecialchars($signalement['status']) ?></p>
<p><strong>Date dépôt :</strong> <?= htmlspecialchars($signalement['dateDepot']) ?></p>

<?php if ($signalement['estAnonyme'] == 0): ?>
    <p><strong>Nom :</strong> <?= htmlspecialchars($signalement['nom']) ?></p>
    <p><strong>Prénom :</strong> <?= htmlspecialchars($signalement['prenom']) ?></p>
<?php else: ?>
    <p><em>Ce signalement est anonyme</em></p>
<?php endif; ?>
