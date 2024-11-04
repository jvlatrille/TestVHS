<?php
// unForum.php

// Inclure le header
include '../includes/header.php';

// Récupérer l'ID du forum depuis l'URL
$forumId = $_GET['id'] ?? null;

// Chemin vers le fichier forum.json
$forumFilePath = $_SERVER['DOCUMENT_ROOT'] . '/PHP/TEST-VHS/donnees/forum.json';

// Charger les données du fichier JSON
$forumData = json_decode(file_get_contents($forumFilePath), true) ?? [];

// Trouver le forum correspondant à l'ID
$forumDetails = null;
foreach ($forumData as $forum) {
    if ($forum['id'] == $forumId) {
        $forumDetails = $forum;
        break;
    }
}

// Vérifier si le forum a été trouvé
if (!$forumDetails) {
    echo "<div class='container mt-5'><p>Forum non trouvé.</p></div>";
    include '../includes/footer.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Forum</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/custom.css">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($forumDetails['title']) ?></h1>
        <p class="text-muted">Créé le : <?= htmlspecialchars($forumDetails['date_creation']) ?> | Dernière modification : <?= htmlspecialchars($forumDetails['date_modification']) ?></p>

        <h3>Description</h3>
        <p><?= nl2br(htmlspecialchars($forumDetails['description'])) ?></p>

        <!-- Ici, vous pouvez ajouter plus de contenu, comme les posts dans le forum, les réponses, etc. -->

        <a href="../pages/forum.php" class="btn btn-secondary mt-3">Retour au Forum</a>
    </div>

    <?php
    include '../includes/footer.php';
    ?>

    <script src="../js/bootstrap.js"></script>

</body>

</html>