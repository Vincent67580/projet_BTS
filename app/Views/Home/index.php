<!-- View/Home/index.php -->
<?php include __DIR__.'/../Views/layout/header.php'; ?>

<style>
    /* Ajustement local pour assurer que les boutons ne dépassent pas */
    .card .btn {
        box-sizing: border-box; /* Inclut le padding dans la largeur de 100% */
        width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    /* Style de la page */
    .intro{
        margin-bottom:3rem;
    }
    .intro-titre{
        font-size: 2.5rem; 
        margin-bottom: 1rem;
    }
    .intro-parag{
        color: var(--text-muted); 
        max-width: 600px; 
        margin: 0 auto;
    }

    .carte{
        display: flex; 
        flex-direction: column; 
        justify-content: space-between;
    }
    .carte-icon{
        font-size: 3rem; 
        margin-bottom: 1rem;
    }
    .carte-parag{
        color: var(--text-muted); 
        margin-bottom: 1.5rem;
    }
    

</style>

<div class="text-center intro" >
    <h1 class="intro-titre">Plateforme de signalement interne</h1>
    <p class="intro-parag" >
        Conformément à la loi Sapin II, cette plateforme sécurisée vous permet de signaler tout comportement 
        contraire au code d'éthique de l'entreprise en toute confidentialité.
    </p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    <!-- Carte Déposer -->
    <div class="card text-center carte">
        <div>
            <div class="carte-icon">📝</div>
            <h3>Déposer une alerte</h3>
            <p class="carte-parag">
                Signalez un incident ou un comportement suspect. Vous pouvez choisir de rester anonyme.
            </p>
        </div>
        <a class="btn" href="Models/depot.php">Commencer le dépôt</a>
    </div>

    <!-- Carte Suivre -->
    <div class="card text-center carte">
        <div>
            <div class="carte-icon">🔍</div>
            <h3>Suivre votre alerte</h3>
            <p class="carte-parag">
                Consultez l'état d'avancement de votre signalement à l'aide de vos identifiants.
            </p>
        </div>
        <a class="btn btn-secondary" href="Models/consulter.php">Accéder au suivi</a>
    </div>
</div>

<?php include __DIR__.'/../Views/layout/footer.php'; ?>