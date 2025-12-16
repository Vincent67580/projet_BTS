<!-- public/index.php -->
<style>
.btn {
    padding: 5px 12px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.container-links {
    margin: 30px auto;
    width: fit-content;
}

.container-links p {
    font-size: 18px;
    margin-bottom: 15px;
}

</style>

<?php include __DIR__.'/../views/layout/header.php'; ?>

<div class="container-links">
    <p>Déposer une alerte : <a class="btn" href="depot.php">déposer</a></p>
    <p>Suivre votre alerte : <a class="btn" href="consulter.php">suivre</a></p>
</div>

<?php include __DIR__.'/../views/layout/footer.php'; ?>

