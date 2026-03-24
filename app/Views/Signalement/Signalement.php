<!-- Views/Signalement/Signalement.php -->

<?php

/*
* Affichage du signalement après connexion
*/


// Couleur selon le statut a modifier
$statusColors = [
    'Nouveau'  => '#3b82f6', // bleu
    'En cours' => '#10b981', // vert
    'Traiter'  => '#ef4444', // rouge
];


$statusColor = $statusColors[$signalement['libelleStatus']] ?? '#6b7280'; // gris par défaut

$_SESSION['libelleStatus'] = $signalement['libelleStatus'];
?>

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
          <img 
    src="<?= BASE_URL ?>index.php?page=fichier&fichier=<?= urlencode($pj['nomFichier']) ?>"
    style="width: 90px; height: 90px; object-fit: cover; border-radius: 8px; cursor: pointer;"
    onclick="ouvrirImage(this.src)"
>
        <?php endforeach; ?>
    </div>

    <!-- Modale -->
    <div id="modale-image" onclick="fermerImage()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:1000; align-items:center; justify-content:center;">
        <img id="modale-img" src="" style="max-width:90%; max-height:90%; border-radius:8px;">
    </div>

    <script>
        function ouvrirImage(src) {
            document.getElementById('modale-img').src = src;
            document.getElementById('modale-image').style.display = 'flex';
        }
        function fermerImage() {
            document.getElementById('modale-image').style.display = 'none';
        }
    </script>
<?php endif; ?>

    
</div>
<div>
    <a href="<?= BASE_URL ?>index.php?page=home" class="back-link">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour à l'accueil
    </a>
</div>


<!-- accès a la messagerie seulement si le signalement n'est pas clos -->
<?php if($signalement['libelleStatus']==='Traiter'): ?>    
    <a href="Models/messagerie.php" class="btn">Voir les messages</a>       
    <a href="<?= BASE_URL ?>index.php?page=signalementConnexions" class="btn" style="background-color:red">Quitter la consultation</a>
<?php else: ?>
    <a href="Models/messagerie.php" class="btn">Accéder à la messagerie</a>       
    <a href="<?= BASE_URL ?>index.php?page=signalementConnexions" class="btn" style="background-color:red">Quitter la consultation</a>
<?php endif; ?>

