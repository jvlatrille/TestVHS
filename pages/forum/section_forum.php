<?php
// section_forum.php
// Utilisation des données de $forum transmises depuis forum.php

?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="mb-0"><?= htmlspecialchars($forum['title']) ?></h5>
    <small class="text-muted">
        Créé le : <?= htmlspecialchars($forum['date_creation']) ?> | Dernière modif : <?= htmlspecialchars($forum['date_modification']) ?>
    </small>
</div>

<p class="text-secondary"><?= htmlspecialchars($forum['description']) ?></p>
<a href="../pages/unForum.php?id=<?= htmlspecialchars($forum['id']) ?>" class="btn btn-outline-primary btn-sm">Voir en détail</a>