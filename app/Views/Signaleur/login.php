
<style>
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

/* Hover */
.btn:hover {
    background: linear-gradient(135deg, #4338ca, #4f46e5);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Active (clic) */
.btn:active {
    transform: translateY(0);
    box-shadow: none;
}

input {
    width: 100%;
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    margin-top: 0.3rem;
    margin-bottom: 0.8rem;
    transition: border 0.2s, box-shadow 0.2s;
}

input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
}
</style>

<div class="card" style="max-width: 500px; margin: 2rem auto;">
    <h2>Se connecter</h2>

    <?php if (isset($erreur)): ?>
        <div style="background: #fee2e2; border: 1px solid #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <p style="margin: 0; color: #ef4444;"><?= htmlspecialchars($erreur) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=login">
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Se connecter</button>
    </form>

    <p style="text-align: center; margin-top: 1rem; color: var(--text-muted);">
        Pas encore de compte ? <a href="<?= BASE_URL ?>index.php?page=inscription">Créer un compte</a>
    </p>
</div>