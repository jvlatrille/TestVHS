<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php

require_once '../Parsedown.php'; // Assure que Parsedown est inclus
$parsedown = new Parsedown();

// Requête GraphQL pour récupérer les animés les mieux notés
$query = <<<'GRAPHQL'
query {
    Page(perPage: 5) {
        media(sort: SCORE_DESC, type: ANIME) {
            id
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
        }
    }
}
GRAPHQL;

// Envoi de la requête vers l'API d'AniList
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

$animeData = json_decode($response, true)['data']['Page']['media'] ?? [];

// Fonction pour afficher le carrousel
function afficherAnimeCarousel($animeData, $parsedown) {
    if (empty($animeData)) {
        echo "<p class='text-center'>Aucune donnée disponible pour le moment.</p>";
        return;
    }
    ?>

    <br>
    <div id="animeCarousel" class="carousel slide" data-bs-ride="carousel">
        <style>
            .anime-poster {
                max-width: 100%;
                height: 450px;
                width: 300px;
                border-radius: 8px;
            }
            .anime-info {
                padding-left: 5px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 100%;
            }
            .star-checked {
                color: #FFD700;
            }
        </style>
        
        <div class="carousel-inner">
            <?php foreach ($animeData as $index => $anime) : ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 d-flex justify-content-center">
                                <img src="<?= $anime['coverImage']['large'] ?>" class="anime-poster" alt="<?= htmlspecialchars($anime['title']['romaji']) ?>">
                            </div>
                            <div class="col-md-4 anime-info">
                                <h3 class="text-primary mb-2"><?= htmlspecialchars($anime['title']['romaji']) ?></h3>
                                <div class="mb-2">
                                    <p class="fw-bold mb-1">Note</p>
                                    <p>
                                        <?php
                                        $score = isset($anime['averageScore']) ? round($anime['averageScore'] / 20) : 0;
                                        for ($i = 1; $i <= 5; $i++) : ?>
                                            <span class="fa fa-star<?= $i <= $score ? ' star-checked' : '' ?>"></span>
                                        <?php endfor; ?>
                                    </p>
                                </div>
                                <div class="mb-2">
                                    <?= $parsedown->text($anime['description']) ?>
                                </div>
                                <a href="details.php?id=<?= $anime['id'] ?>" class="btn btn-outline-primary mt-2">En discuter</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#animeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#animeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <?php
}
afficherAnimeCarousel($animeData, $parsedown);
?>
