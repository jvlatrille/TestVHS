<?php
// forum.php

// Inclure le header
include '../includes/header.php';

// Charger le contenu du fichier forum.json
$forumData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/PHP/TEST-VHS/donnees/forum.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/custom.css">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Forum</h1>

        <?php foreach ($forumData as $forum): ?>
            <!-- Inclure la section du forum pour chaque élément dans forum.json -->
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/PHP/TEST-VHS/pages/forum/section_forum.php'; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Bouton flottant pour créer un nouveau forum -->
    <button type="button" class="btn btn-primary position-fixed" style="bottom: 20px; right: 20px;" data-bs-toggle="modal" data-bs-target="#createForumModal">
        <img src="../img/stylo_creation.png" alt="Créer un nouveau forum" style="width: 24px; height: 24px;">
    </button>
    <!-- Pop-up de création de forum -->
    <div class="modal fade" id="createForumModal" tabindex="-1" aria-labelledby="createForumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createForumModalLabel">Créer un nouveau forum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/PHP/TEST-VHS/pages/forum/create_forum_action.php" method="POST">
                        <div class="mb-3">
                            <label for="forumTitle" class="form-label">Nom du forum</label>
                            <input type="text" class="form-control" id="forumTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="forumDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="forumDescription" name="description" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Créer le forum</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../includes/footer.php';
    ?>

    <script src="../js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>