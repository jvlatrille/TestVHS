<?php
session_start();
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: ../index.php");
    exit();
}

$profilPath = __DIR__ . '/profil/infosUtilisateur.json';

// Charger les informations de l'utilisateur depuis le JSON
$profilData = json_decode(file_get_contents($profilPath), true);

// Valeurs par défaut si certains champs sont vides
$userData = $profilData[$userId] ?? [
    "username" => "Utilisateur",
    "pfp" => "../profil/photosUser/default-pfp.jpg",
    "banner" => "../profil/photosUser/default-banner.jpg",
    "description" => "Bienvenue sur mon profil !"
];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Mon Profil</title>
</head>

<body>
    <div class="container mt-5">
        <!-- Bannière du profil -->
        <div class="profile-banner" style="background-image: url('<?= htmlspecialchars($userData['banner']) ?>'); height: 200px; background-size: cover;">
        </div>

        <!-- Photo de profil -->
        <div class="text-center">
            <img src="<?= htmlspecialchars($userData['pfp']) ?>" class="rounded-circle mt-3" alt="Photo de profil" width="150" height="150">
        </div>

        <!-- Nom d'utilisateur et description -->
        <h3 class="text-center mt-3"><?= htmlspecialchars($userData['username']) ?></h3>
        <p class="text-center"><?= htmlspecialchars($userData['description']) ?></p>

        <!-- Formulaire de mise à jour du profil -->
        <form action="profil/updateProfile.php" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($userData['username']) ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($userData['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="pfp" class="form-label">Photo de profil</label>
                <input type="file" class="form-control" id="pfp" name="pfp">
            </div>

            <div class="mb-3">
                <label for="banner" class="form-label">Bannière</label>
                <input type="file" class="form-control" id="banner" name="banner">
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
        </form>
    </div>

    <script src="../js/bootstrap.js"></script>
</body>

</html>