<!-- /Views/Consultations/consulter_messagerie.php -->
<!-- uniquement consultation des messages transmis (page visible si le signalment est clos) -->

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



</style>

<h2>Messagerie du signalement</h2>

<a href="<?= BASE_URL ?>index.php?page=signalementConnexions" class="back-link">← Retour au signalement</a>
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


</body>
<script>
    const messages = document.querySelector('.messages');

    if (messages) {
        messages.scrollTop = messages.scrollHeight;
    }
</script>
