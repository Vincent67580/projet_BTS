

 <div class="card text-center carte">
        <div>
            <h2>Signalement envoyé</h2>

<p>Votre numéro de dossier :</p>

<h3><?= htmlspecialchars($numero) ?></h3>

<p>Conservez ce numéro pour suivre votre dossier.</p>
        <a class="btn" href="<?= BASE_URL ?>index.php?page=depot">Refaire un dépôt</a>
        <a href="<?= BASE_URL ?>index.php?page=signalementConnexions" class="btn"> Consulter mon dossier</a>
    </div>