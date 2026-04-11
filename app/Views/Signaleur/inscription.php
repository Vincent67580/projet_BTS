<style>

/* Bouton */
.btn {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn:hover {
    background: linear-gradient(135deg, #4338ca, #4f46e5);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn:active {
    transform: translateY(0);
    box-shadow: none;
}

/* Inputs */

input {
    width: 100%;
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    margin-top: 0.3rem;
    margin-bottom: 0.8rem;
    transition: border 0.2s, box-shadow 0.2s;
}

/* Focus */
input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
}

/* Labels */
label {
    font-weight: 500;
}

/* Responsive (important pour mobile 👇) */
@media (max-width: 600px) {
    form div[style*="grid"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<div class="card" style="max-width: 500px; margin: 2rem auto;">
    <h2>Créer un compte</h2>

    <?php if (!empty($erreurs)): ?>
        <div style="background: #fee2e2; border: 1px solid #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <?php foreach ($erreurs as $erreur): ?>
                <p style="margin: 0; color: #ef4444;"><?= htmlspecialchars($erreur) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=inscription">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label>Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($formData['nom'] ?? '') ?>" required>
            </div>
            <div>
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($formData['prenom'] ?? '') ?>" required>
            </div>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
        </div>
        <div>
            <label>Téléphone <span style="color: var(--text-muted); font-size: 0.85rem;">(optionnel)</span></label>
            <input type="tel" name="telephone" value="<?= htmlspecialchars($formData['telephone'] ?? '') ?>">
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirm" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Créer mon compte</button>
    </form>

    <p style="text-align: center; margin-top: 1rem; color: var(--text-muted);">
        Déjà un compte ? <a href="<?= BASE_URL ?>index.php?page=login">Se connecter</a>
    </p>
</div>