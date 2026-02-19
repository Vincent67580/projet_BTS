<?php 
/**
 * Vue du formulaire de consultation d'un signalement
 * Design harmonisé avec le formulaire de dépôt
 */
?>

<style>
    /* Structure de la page */
    .page-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc; 
        padding: 25px 15px;
    }

    .form-container {
        padding: 40px;
        width: 100%;
        max-width: 450px;
        background: #ffffff;
        border-radius: 16px; 
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        text-align: center;
    }

    .form-container h2 {
        margin-bottom: 30px;
        color: #0f172a;
        font-size: 26px;
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 24px;
        text-align: left;
    }

    .form-container label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #334155;
        font-size: 15px;
    }

    /* Conteneur pour le mot de passe */
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-container input {
        width: 100%;
        padding: 14px;
        padding-right: 90px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        box-sizing: border-box;
        font-size: 16px;
        transition: all 0.3s ease;
        background-color: #fcfcfc;
    }

    .form-container input:focus {
        border-color: #2563eb;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Style du bouton de bascule du mot de passe */
    .toggle-password {
        position: absolute;
        right: 10px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #64748b;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        user-select: none;
        transition: all 0.2s;
    }

    .toggle-password:hover {
        color: #2563eb;
        background-color: #eff6ff;
        border-color: #bfdbfe;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        cursor: pointer;
        border: none;
        border-radius: 10px;
        background: #2563eb;
        color: white;
        font-size: 16px;
        font-weight: 600;
        transition: transform 0.1s, background 0.2s;
        margin-top: 10px;
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
    }

    .btn-submit:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .error-message {
        color: #b91c1c;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        padding: 14px;
        margin-bottom: 25px;
        border-radius: 10px;
        font-size: 14px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 8px;
    }

</style>

<div class="page-wrapper">
    <div class="form-container">
        <h2>Consulter une alerte</h2>

        <!-- Affichage des erreurs de connexion -->
        <?php if (!empty($erreur)): ?>
            <div class="error-message">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span><?= htmlspecialchars($erreur) ?></span>
            </div>
        <?php endif; ?>

        <form action="../app/Models/consulter.php" method="post">
            <div class="form-group">
                <label for="numeroDossier">Numéro de dossier</label>
                <input type="text" 
                       name="numeroDossier" 
                       id="numeroDossier" 
                       placeholder="Saisissez votre code dossier..." 
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label for="motDePasse">Mot de passe</label>
                <div class="password-wrapper">
                    <input type="password" 
                           name="motDePasse" 
                           id="motDePasse" 
                           placeholder="Mot de passe"
                           required>
                    <button type="button" id="togglePassword" class="toggle-password">Afficher</button>
                </div>
            </div>

            <button type="submit" class="btn-submit">Accéder au signalement</button>
        </form>
    </div>
</div>

<div>
    <a href="<?= BASE_URL ?>index.php?page=home" class="back-link">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour à l'accueil
    </a>
</div>

<script>
    
    //  Logique de bascule pour afficher ou masquer le mot de passe
     
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('motDePasse');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                this.textContent = isPassword ? 'Masquer' : 'Afficher';
                passwordInput.focus();
            });
        }
    });
</script>