<!-- views/depot_alerte.php -->

<h2>Déposer une alerte</h2>

<form action="../public/depot.php" method="post">

    <label for="typeSignalement">Type de signalement :</label><br>
    <select name="typeSignalement" id="typeSignalement" required>
        <option value="">-- Choisir --</option>
        <option value="Harcèlement">Harcèlement</option>
        <option value="Corruption">Corruption</option>
        <option value="Fraude">Fraude</option>
        <option value="Sécurité">Sécurité</option>
    </select><br><br>

    <label for="description">Description :</label><br>
    <textarea name="description" id="description" rows="5" cols="40" required></textarea><br><br>

    <label>
        <input type="checkbox" name="estAnonyme" value="1"> Déposer anonymement
    </label><br><br>

    <div id="infosPerso">
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom"><br><br>

        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom"><br><br>
    </div>

    <button type="submit">Envoyer</button>
</form>


<script>
// Si la case anonymat est cochée cacher nom/prénom
document.querySelector("input[name='estAnonyme']").addEventListener("change", function() {
    document.getElementById("infosPerso").style.display = this.checked ? "none" : "block";
});
</script>
