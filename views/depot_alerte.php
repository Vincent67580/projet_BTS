<!-- views/depot_alerte.php -->

<style>
.form-container {
    margin: auto;
    padding: 20px;
    width: 50%;
    background: #f8f8f8;
    border-radius: 8px;
    box-shadow: 0 0 10px #0002;
}

.form-container input:not(.check),.form-container select, .form-container textarea {
    width: 90%;
    padding: 8px;
    margin: 10px auto;
    display: block;
}

label input.check {
    display: inline-block;
    margin-right: 6px;
}

button {
    padding: 10px 20px;
    cursor: pointer;
}

.btn {
    padding: 5px 12px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.error-message {
    color: #c0392b;
    font-size: 14px;
    display: none;
    margin-top: 5px;
}

#listePJ {
    list-style: none;
    padding-left: 0;
}

</style>

<div class="form-container">
    <h2>Déposer une alerte</h2>

    <form id="formAlerte" action="../public/depot.php" method="post" enctype="multipart/form-data">

        <label for="idTypeSignalement">Type de signalement :</label>
        <select name="idTypeSignalement" id="idTypeSignalement" >
            <option value="">-- Choisir --</option>
            <option value="1">Harcèlement</option>
            <option value="2">Corruption</option>
            <option value="3">Fraude</option>
            <option value="4">Sécurité</option>
            <option value="5">Autre</option>
        </select>
        <p id="errorType" style="color:red; display:none; margin-top:5px;"></p>

        <label for="contenu">Description :</label>
        <textarea name="contenu" id="contenu" rows="5" ></textarea>
        <p id="errorDescription" style="color:red; display:none; margin-top:5px;"></p>

        <label>
            <input class="check" type="checkbox" name="estAnonyme" value="1"> Déposer anonymement
        </label>

        <div id="infosPerso">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" >

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" >

            <p id="errorNomPrenom" style="color:red; display:none; margin-top:5px;"></p>
        </div>

        <label for="pj">Joindre des fichiers :</label>
        <input type="file" name="pj[]" id="pj" multiple accept="image/png, image/jpeg, image/jpg, image/gif">
        <p id="errorPJ" style="color:red; display:none; margin-top:5px;"></p>
        <ul id="listePJ" style="list-style:none; padding-left:0;"></ul>

        <label for="mdp">Mot de passe pour consulter l’alerte :</label>
        <input type="password" name="mdp" id="mdp" >
        <p id="errorMdp" style="color:red; display:none; margin-top:5px;"></p>

        <button type="submit">Envoyer</button>
    </form>
</div>
<a class = "btn" href="index.php">Retour à l'accueil</a>



