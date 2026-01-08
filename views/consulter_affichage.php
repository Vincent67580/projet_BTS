<!-- views/consulter_affichage.php -->
<?php
// Récupération des PJ
$stmtPJ = $pdo->prepare("
    SELECT pj.nomFichier, pj.cheminFichier
    FROM PieceJointe pj
    JOIN AjouterPJ ap ON ap.idPJ = pj.idPJ
    WHERE ap.idSignalement = ?
");
$stmtPJ->execute([$signalement['idSignalement'] ?? 0]); 
$piecesJointes = $stmtPJ->fetchAll();

// Couleur selon le statut a modifier
$statusColor = ($signalement['libelleStatus'] == 'Reçu') ? '#3b82f6' : '#10b981';
?>

<style>
    .back-link {
        margin-top: 30px;
        text-decoration: none;
        color: #64748b;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #0f172a;
        text-decoration: none;
    }
</style>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
        <div>
            <span style="text-transform: uppercase; font-size: 0.75rem; font-weight: 800; color: var(--text-muted);">Référence dossier</span>
            <h2 style="margin: 0; color: var(--primary-color);">#<?= htmlspecialchars($signalement['numeroDossier']) ?></h2>
        </div>
        <div style="text-align: right;">
            <span style="display: inline-block; padding: 0.25rem 0.75rem; background: <?= $statusColor ?>; color: white; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                <?= htmlspecialchars($signalement['libelleStatus']) ?>
            </span>
            <p style="margin: 5px 0 0 0; font-size: 0.8rem; color: var(--text-muted);">Déposé le <?= date('d/m/Y', strtotime($signalement['dateDepot'])) ?></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div class="info-block">
            <h4 style="margin-bottom: 0.5rem; color: var(--text-muted);">Émetteur</h4>
            <?php if ($signalement['estAnonyme'] == 0): ?>
                <p style="font-weight: 600; margin: 0;"><?= htmlspecialchars($signalement['prenom'] . ' ' . $signalement['nom']) ?></p>
            <?php else: ?>
                <p style="font-style: italic; margin: 0; color: var(--text-muted);">Anonyme</p>
            <?php endif; ?>
        </div>
        <div class="info-block">
            <h4 style="margin-bottom: 0.5rem; color: var(--text-muted);">Type d'alerte</h4>
            <p style="font-weight: 600; margin: 0;"><?= htmlspecialchars($signalement['libelleType']) ?></p>
        </div>
    </div>

    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <h4 style="margin-top: 0; margin-bottom: 1rem; color: var(--text-muted);">Description des faits</h4>
        <p style="margin: 0; white-space: pre-wrap;"><?= nl2br(htmlspecialchars($signalement['contenu'])) ?></p>
    </div>

    <?php if (!empty($piecesJointes)): ?>
        <h4 style="color: var(--text-muted); margin-bottom: 1rem;">Pièces jointes</h4>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <?php foreach ($piecesJointes as $pj): ?>
                <a href="../public/<?= htmlspecialchars($pj['cheminFichier']) ?>" target="_blank" style="border: 1px solid var(--border-color); padding: 5px; border-radius: 8px; transition: transform 0.2s;">
                    <img src="../public/<?= htmlspecialchars($pj['cheminFichier']) ?>" alt="PJ" style="width: 90%; height: auto; object-fit: cover; border-radius: 4px;">
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    
</div>
<div>
    <a href="index.php" class="back-link">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour à l'accueil
    </a>
</div>

<a href="messagerie.php">Accéder à la messagerie</a> |<br>
<a href="deconnexion.php">Quitter la consultation</a>