<h2>Mes signalements</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Numéro de dossier</th>
        <th>Type</th>
        <th>Date de dépôt</th>
    </tr>

    <?php foreach ($signalements as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['numeroDossier']) ?></td>
            <td><?= htmlspecialchars($s['typeSignalement']) ?></td>
            <td><?= htmlspecialchars($s['dateDepot']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>