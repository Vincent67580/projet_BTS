<!-- views/consulter_alerte.php -->
<h2>Consulter une alerte</h2>

<form action="consulter.php" method="post">

    <label for="numeroDossier">Numéro de dossier :</label><br>
    <input type="text" name="numeroDossier" id="numeroDossier" required><br><br>

    <label for="motDePasse">Mot de passe :</label><br>
    <input type="password" name="motDePasse" id="motDePasse" required><br><br>

    <button type="submit">Voir le signalement</button>
</form>
