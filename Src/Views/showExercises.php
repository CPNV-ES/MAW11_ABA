<?php if (!empty($exercises)): ?>
    <h2>Liste des exercices</h2>
    <ul>
        <?php foreach ($exercises as $exercise): ?>
            <li>
                ID: <?= htmlspecialchars($exercise['id']) ?> -
                Titre: <?= htmlspecialchars($exercise['titre']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun exercice trouvé.</p>
<?php endif; ?>
