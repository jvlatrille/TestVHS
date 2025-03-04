<?php
include '../includes/header.php';
include '../db/config.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        /* Arrière-plan dégradé pour éviter les coupures */
        body {
            margin: 0;
            padding: 0;
        }

        /* Conteneur 100% transparent */
        .section-container {
            padding: 20px;
            background-color: transparent;
            /* Aucun fond */
            border-radius: 8px;
            margin: 20px auto;
            max-width: 1200px;
        }

        /* Transition d'apparition pour un effet smooth */
        .fade-in {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        /* Classe pour rendre l'élément visible */
        .visible {
            opacity: 1;
        }
    </style>
</head>

<body>

    <!-- Tête d'affiche avec animation -->
    <div class="section-container fade-in">
        <?php include 'accueil/tete_affiche.php'; ?>
    </div>

    <!-- Affichage des catégories avec animation -->
    <div class="section-container fade-in">
        <?php include 'accueil/afficher_categories.php'; ?>
    </div>

    <?php
    include '../includes/footer.php';
    $conn->close();
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ajouter la classe visible pour l'effet smooth
        document.addEventListener("DOMContentLoaded", () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach(element => {
                setTimeout(() => {
                    element.classList.add('visible');
                }, 200);
            });
        });
    </script>

</body>

</html>