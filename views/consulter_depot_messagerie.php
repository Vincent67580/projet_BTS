<!-- views/consulter_depot_messagerie.php -->


<h2>Messagerie du signalement</h2>

<div class="messages">

    <?php if (empty($messages)): ?>
        <p>Aucun message pour le moment.</p>
    <?php endif; ?>

    <?php foreach ($messages as $msg): ?>
        <div class="message <?= strtolower($msg['origine']) ?>">
            <strong><?= htmlspecialchars($msg['origine']) ?> :</strong>
            <p><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
            <small><?= htmlspecialchars($msg['dateMessage']) ?></small>
        </div>
        <br>
    <?php endforeach; ?>

</div>

<hr>

<form method="post">
    <label for="message">Votre message :</label><br>
    <input
        type="text"
        id="message"
        name="message"
        placeholder="Écrivez votre message"
        required
    >
    <br><br>
    <button type="submit">Envoyer</button>
</form>
<hr>
<br>

<a href="consulter.php">← Retour à la consultation</a>
