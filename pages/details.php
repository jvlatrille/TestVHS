<?php
require_once '../Parsedown.php';
require_once '../vendor/autoload.php';

include '../includes/header.php';
include '../db/config.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

$parsedown = new Parsedown();
$tr = new GoogleTranslate('fr');

$id = $_GET['id']; // ID du film à afficher

// Requête GraphQL pour récupérer les informations détaillées du film
$query = <<<GRAPHQL
query {
    Media(id: $id, type: ANIME) {
        title {
            romaji
            english
            native
        }
        coverImage {
            large
        }
        description(asHtml: false)
        averageScore
        genres
        episodes
        duration
        startDate {
            year
            month
            day
        }
        endDate {
            year
            month
            day
        }
        studios(isMain: true) {
            nodes {
                name
            }
        }
        recommendations(perPage: 10, sort: RATING_DESC) {
            edges {
                node {
                    mediaRecommendation {
                        id
                        title {
                            romaji
                        }
                        coverImage {
                            large
                        }
                    }
                }
            }
        }
    }
}
GRAPHQL;

$ch = curl_init('https://graphql.anilist.co');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
$response = curl_exec($ch);
curl_close($ch);

$anime = json_decode($response, true)['data']['Media'] ?? null;

if (!$anime) {
    echo "<p>Aucune information trouvée pour cet anime.</p>";
    exit;
}

// Traduire la description
$descriptionFr = $tr->translate($anime['description']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($anime['title']['romaji']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        /* Applique le fond sur toute la hauteur de la page */
        body,
        html {
            height: 100%;
            background: linear-gradient(to right, #a20000, #0D6EFD);
        }

        /* Container avec fond gris transparent */
        .content-container {
            background-color: rgba(33, 37, 41, 0.85);
            color: #eaeaea;
            padding: 20px;
            border-radius: 8px;
        }

        /* Styles pour le menu défilant */
        .recommendation-list {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px;
            scroll-snap-type: x mandatory;
            max-width: 100%;
        }

        .recommendation-item {
            flex: 0 0 auto;
            scroll-snap-align: start;
            width: 150px;
            background-color: #333;
        }

        /* Style personnalisé pour la barre de défilement */
        .recommendation-list::-webkit-scrollbar {
            height: 8px;
        }

        .recommendation-list::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
        }

        .recommendation-list::-webkit-scrollbar-thumb {
            background-color: #0D6EFD;
            border-radius: 8px;
        }

        .recommendation-list::-webkit-scrollbar-thumb:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container content-container mt-5 p-5 rounded">
        <div class="row g-4">
            <!-- Affiche du film à gauche -->
            <div class="col-md-4 text-center">
                <img src="<?= $anime['coverImage']['large'] ?>" alt="<?= htmlspecialchars($anime['title']['romaji']) ?>" class="img-fluid rounded" style="max-width: 100%; height: auto;">
            </div>

            <!-- Titre, Note, et Description à droite -->
            <div class="col-md-8">
                <h1 class="text-warning mb-3"><?= htmlspecialchars($anime['title']['romaji']) ?></h1>

                <!-- Note en étoiles -->
                <div class="mb-2">
                    <p class="fw-bold mb-1">Note :</p>
                    <?php
                    $score = isset($anime['averageScore']) ? round($anime['averageScore'] / 20) : 0;
                    for ($i = 1; $i <= 5; $i++) {
                        echo '<span class="fa fa-star' . ($i <= $score ? ' text-warning' : ' text-muted') . '"></span>';
                    }
                    ?>
                </div>

                <!-- Informations supplémentaires -->
                <ul class="list-unstyled mt-3">
                    <li><strong>Genres :</strong> <?= implode(", ", $anime['genres']) ?></li>
                    <li><strong>Nombre d'épisodes :</strong> <?= $anime['episodes'] ?? 'Inconnu' ?></li>
                    <li><strong>Durée d'un épisode :</strong> <?= $anime['duration'] ? $anime['duration'] . ' minutes' : 'Inconnu' ?></li>
                    <li><strong>Date de début :</strong> <?= $anime['startDate']['year'] ? "{$anime['startDate']['year']}-{$anime['startDate']['month']}-{$anime['startDate']['day']}" : 'Inconnue' ?></li>
                    <li><strong>Date de fin :</strong> <?= $anime['endDate']['year'] ? "{$anime['endDate']['year']}-{$anime['endDate']['month']}-{$anime['endDate']['day']}" : 'Inconnue' ?></li>
                    <li><strong>Studio :</strong> <?= $anime['studios']['nodes'][0]['name'] ?? 'Inconnu' ?></li>
                </ul>

                <!-- Description traduite -->
                <div class="mt-3">
                    <?= $parsedown->text($descriptionFr) ?>
                </div>

                <a href="#" class="btn btn-outline-light mt-4">En discuter</a>
            </div>
        </div>

        <!-- Recommandations en défilement horizontal avec style de barre de défilement -->
        <?php if (!empty($anime['genres'])) : ?>
            <h2 class="mt-5 text-light">Films similaires dans la catégorie : <?= htmlspecialchars($anime['genres'][0]) ?></h2>
            <div class="recommendation-list">
                <?php foreach ($anime['recommendations']['edges'] as $recommendation) :
                    $rec = $recommendation['node']['mediaRecommendation'];
                ?>
                    <div class="recommendation-item card text-center border-0 rounded">
                        <a href="details.php?id=<?= $rec['id'] ?>" class="text-decoration-none text-light">
                            <img src="<?= $rec['coverImage']['large'] ?>" class="card-img-top rounded" alt="<?= htmlspecialchars($rec['title']['romaji']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <p class="card-title mb-0"><?= htmlspecialchars($rec['title']['romaji']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?php
include '../includes/footer.php';
$conn->close();
?>