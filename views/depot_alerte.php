<!-- views/depot_alerte.php -->
<style>
    .form-group { 
        margin-bottom: 1.5rem; 
        text-align: left; 
    }
    .form-group label { 
        display: block; 
        margin-bottom: 0.5rem; 
        font-weight: 600; 
        color: #374151; 
    }
    .form-control {
        width: 100%; 
        padding: 0.75rem; 
        border: 1px solid var(--border-color);
        border-radius: 8px; 
        font-size: 1rem; 
        transition: border-color 0.2s;
        box-sizing: border-box; /* Empêche le débordement */
    }
    .form-control:focus { 
        outline: none; 
        border-color: var(--primary-color); 
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); 
    }
    .checkbox-group { 
        display: flex; 
        align-items: center; 
        gap: 0.5rem; 
        background: #f3f4f6; 
        padding: 1rem; 
        border-radius: 8px; 
        margin-bottom: 1.5rem; 
    }
    .error-msg { 
        color: var(--error); 
        font-size: 0.85rem; 
        margin-top: 0.25rem; 
        display: none; 
    }
    
    /* Correction du chevauchement Nom/Prénom */
    .name-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem; /* Espace entre les deux colonnes */
    }

    /* Empilage automatique sur mobile pour éviter le chevauchement */
    @media (max-width: 480px) {
        .name-grid {
            grid-template-columns: 1fr;
        }
    }

    #listePJ li {
        background: #f9fafb; 
        padding: 0.5rem 1rem; 
        border-radius: 6px; 
        margin-bottom: 0.5rem;
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        border: 1px solid var(--border-color);
    }
</style>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2 class="text-center">Nouveau signalement</h2>
    
    <form id="formAlerte" action="../public/depot.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="idTypeSignalement">Nature de l'alerte</label>
            <select name="idTypeSignalement" id="idTypeSignalement" class="form-control">
                <option value="">-- Sélectionner le type --</option>
                <option value="1">Harcèlement</option>
                <option value="2">Corruption</option>
                <option value="3">Fraude</option>
                <option value="4">Sécurité</option>
                <option value="5">Autre</option>
            </select>
            <p id="errorType" class="error-msg"></p>
        </div>

        <div class="form-group">
            <label for="contenu">Description détaillée des faits</label>
            <textarea name="contenu" id="contenu" rows="6" class="form-control" placeholder="Décrivez les faits, les dates, les lieux et les personnes impliquées..."></textarea>
            <p id="errorDescription" class="error-msg"></p>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="estAnonyme" id="estAnonyme" value="1" style="width: 20px; height: 20px;">
            <label for="estAnonyme" style="margin: 0; cursor: pointer;">Déposer ce signalement anonymement</label>
        </div>

        <div id="infosPerso">
            <div class="name-grid">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control js-proper-name">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control js-proper-name">
                </div>
            </div>
            <p id="errorNomPrenom" class="error-msg" style="margin-top: -0.5rem; margin-bottom: 1rem;"></p>
        </div>

        <div class="form-group">
            <label for="pj">Pièces jointes (Images uniquement, max 2Mo)</label>
            <input type="file" name="pj[]" id="pj" multiple accept="image/*" class="form-control" style="padding: 0.5rem;">
            <p id="errorPJ" class="error-msg"></p>
            <ul id="listePJ" style="margin-top: 1rem; padding: 0;"></ul>
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe de consultation</label>
            <div class="password-wrapper" style="position: relative;">
                <input type="password" name="mdp" id="mdp" class="form-control">
                <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--primary-color); cursor: pointer; font-size: 0.8rem;">Afficher</button>
            </div>
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Min. 12 caractères, majuscule, chiffre et caractère spécial.</p>
            <p id="errorMdp" class="error-msg"></p>
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-top: 1rem;">Envoyer le signalement</button>
    </form>
</div>

<div class="text-center mt-4">
    <a href="index.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">← Retour</a>
</div>

<script>
    const toggleBtn = document.getElementById('togglePassword');
    const mdpInput = document.getElementById('mdp');
    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const type = mdpInput.type === 'password' ? 'text' : 'password';
            mdpInput.type = type;
            toggleBtn.textContent = type === 'password' ? 'Afficher' : 'Masquer';
        });
    }

    // Gestion de l'affichage dynamique nom/prénom
    const checkboxAnonyme = document.getElementById('estAnonyme');
    const infosPerso = document.getElementById('infosPerso');
    if(checkboxAnonyme) {
        checkboxAnonyme.addEventListener('change', function() {
            infosPerso.style.display = this.checked ? 'none' : 'block';
        });
    }

    // Formater en "Nom Propre" (1ère lettre majuscule, reste minuscule)
    document.querySelectorAll('.js-proper-name').forEach(input => {
        input.addEventListener('blur', function() {
            let val = this.value.trim();
            if (val.length > 0) {
                // On gère aussi les noms composés avec un tiret ou un espace
                this.value = val.split(/([- ])/).map(part => {
                    if (part === '-' || part === ' ') return part;
                    return part.charAt(0).toUpperCase() + part.slice(1).toLowerCase();
                }).join('');
            }
        });
    });
</script>