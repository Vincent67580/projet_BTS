<!-- public/index.php -->
<?php include __DIR__.'/../views/layout/header.php'; ?>

<style>
    /* Ajustement local pour assurer que les boutons ne dépassent pas */
    .card .btn {
        box-sizing: border-box; /* Inclut le padding dans la largeur de 100% */
        width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    /* Optionnel : On peut aussi forcer le box-sizing globalement dans main.css si ce n'est pas déjà fait */
</style>

<div class="text-center" style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Plateforme de signalement interne</h1>
    <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto;">
        Conformément à la loi Sapin II, cette plateforme sécurisée vous permet de signaler tout comportement 
        contraire au code d'éthique de l'entreprise en toute confidentialité.
    </p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    <!-- Carte Déposer -->
    <div class="card text-center" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
            <h3>Déposer une alerte</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                Signalez un incident ou un comportement suspect. Vous pouvez choisir de rester anonyme.
            </p>
        </div>
        <a class="btn" href="depot.php">Commencer le dépôt</a>
    </div>

    <!-- Carte Suivre -->
    <div class="card text-center" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
            <h3>Suivre votre alerte</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                Consultez l'état d'avancement de votre signalement à l'aide de vos identifiants.
            </p>
        </div>
        <a class="btn btn-secondary" href="consulter.php">Accéder au suivi</a>
    </div>
</div>

<?php include __DIR__.'/../views/layout/footer.php'; ?>