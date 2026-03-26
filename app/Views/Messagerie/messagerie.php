<!-- Views/Consultations/consulter_depot_messagerie.php -->


<style>
    .messages{
        border-radius: 16px; 
        border: 2px solid #e2e8f0;
        height:45VH;
        overflow-y: auto;
    }

    .signaleur{
        text-align:right;
    }
    .rh{
        text-align:left;
    }
    .contenu-message{
        display: inline-block;
        margin:2px 8px;
        padding : 8px;
        max-width:75%;
        border-radius:14px
    }
    .date-message{
        display:block;
        font-size : 9px;
        margin:0px 8px
    }
    .signaleur .contenu-message {
        margin-left: auto;  
        background-color: #e8ffebff;
    }
    .rh .contenu-message {
        background-color: #eaecf2ff;
    }



/* Formulaire sous les messages */
form {
    margin: 16px auto 0 auto;
    width: 100%;
    max-width: 700px;

    display: flex;
    align-items: flex-end;
    gap: 10px;

    background-color: #ffffff;
    padding: 12px 16px;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

/* On masque le label */
form label {
    display: none;
}

/* Zone de saisie */
form textarea {
    flex: 1;
    resize: none;

    border: none;
    outline: none;
    padding: 12px 14px;

    font-size: 14px;
    border-radius: 12px;
    background-color: #f8fafc;
    min-height: 44px;
    max-height: 120px;
}

/* Bouton envoyer */
form button {
    background-color: #10a37f;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 10px 16px;

    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

form button:hover {
    background-color: #0e8c6c;
}



</style>

<h2>Messagerie du signalement</h2>

<a href="<?= BASE_URL ?>index.php?page=consultation" class="back-link">← Retour au signalement</a>
<br>

<div class="messages">

    <?php if (empty($messages)): ?>
        <p style="margin-top:100px;  margin-left:350px">Aucun message pour le moment...</p>
    <?php endif; ?>

    <?php foreach ($messages as $msg): ?>
        <div class="message <?= strtolower($msg['origine']) ?>">
            <!-- <strong class="personne"><?= $msg['origine'] === "SIGNALEUR" ? 'Vous' : 'RH' ?> :</strong> -->
            <p class="contenu-message"><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
            <small class="date-message"><?= htmlspecialchars($msg['dateMessage']) ?></small>
        </div>
        <br>
    <?php endforeach; ?>

</div>



<form method="post">
    <label for="message">Votre message :</label><br>
    <textarea
        id="message"
        name="message"
        placeholder="Écrivez votre message"
        required
        rows="4"
        cols="50"
    ></textarea>
    <button type="submit">Envoyer</button>
</form>

</body>
<script>
    const messages = document.querySelector('.messages');

    if (messages) {
        messages.scrollTop = messages.scrollHeight;
    }
</script>
