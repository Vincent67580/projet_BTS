<!-- views/consulter_form.php -->
<?php
$pageCSS = 'consulter';
?>

<style>
.form-container {
    margin: 40px auto;
    padding: 25px;
    width: 35%;
    background: #f8f8f8;
    border-radius: 8px;
    box-shadow: 0 0 10px #0002;
    text-align: center;
}

.form-container h2 {
    margin-bottom: 20px;
}

.form-container label {
    display: block;
    text-align: left;
    margin-left: 7%;
    font-weight: bold;
    margin-top: 15px;
}

.form-container input {
    width: 85%;
    padding: 8px;
    margin-top: 6px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-container button {
    padding: 10px 25px;
    cursor: pointer;
    margin-top: 20px;
    border: none;
    border-radius: 5px;
    background: #007bff;
    color: white;
    font-size: 16px;
}

.form-container button:hover {
    background: #0069d9;
}

.error-message {
    color: #c0392b;
    background: #fdecea;
    border: 1px solid #e0b4b4;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    font-weight: 500;
}

.btn {
    padding: 5px 12px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
</style>

<div class="form-container">
    <h2>Consulter une alerte</h2>

    <?php if (!empty($erreur)): ?>
        <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    <form action="../public/consulter.php" method="post">

        <label for="numeroDossier">Numéro de dossier :</label>
        <input type="text" name="numeroDossier" id="numeroDossier" required>

        <label for="motDePasse">Mot de passe :</label>
        <input type="password" name="motDePasse" id="motDePasse" required>

        <button type="submit">Voir le signalement</button>
    </form>
</div>
<a class = "btn" href="index.php">Retour à l'accueil</a>

