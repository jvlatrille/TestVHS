<?php
include 'db/config.php';

// Exemple de requête pour vérifier la connexion
$sql = "SELECT * FROM Utilisateur";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher les données si nécessaire
} else {
    echo "Aucun utilisateur trouvé.";
}

$conn->close();
?>

<div class="container">
    <h1>Bienvenue sur VHS !</h1>
    <p>Votre espace pour partager et découvrir des films et séries en toute convivialité.</p>
</div>

<?php
header("Location: pages/accueil.php");
exit();
?>
