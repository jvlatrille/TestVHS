<?php
require_once '../Parsedown.php';
require_once '../vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

$parsedown = new Parsedown();
$tr = new GoogleTranslate('fr');

// Requête pour récupérer tous les genres
$queryGenres = <<<'GRAPHQL'
query {
    GenreCollection
}
GRAPHQL;

$ch = curl_init('https://graphql.anilist.co');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $queryGenres]));
$responseGenres = curl_exec($ch);
curl_close($ch);

$genres = json_decode($responseGenres, true)['data']['GenreCollection'] ?? [];

$selectedGenre = $_GET['genre'] ?? 'Action';

$queryAnime = <<<GRAPHQL
query {
    Page(perPage: 20) {
        media(sort: SCORE_DESC, type: ANIME, genre: "$selectedGenre") {
            id
            title {
                romaji
            }
            coverImage {
                large
            }
            averageScore
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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $queryAnime]));
$responseAnime = curl_exec($ch);
curl_close($ch);

$animeData = json_decode($responseAnime, true)['data']['Page']['media'] ?? [];

function afficherCategorieCarousel($animeData, $parsedown, $tr, $selectedGenre, $genres)
{
?>
    <div class="container my-5">
        <h3 class="text-primary">Catégorie :
            <select onchange="window.location.href='?genre=' + this.value" class="form-select d-inline-block w-auto">
                <?php foreach ($genres as $genre) : ?>
                    <option value="<?= $genre ?>" <?= $genre === $selectedGenre ? 'selected' : '' ?>><?= $genre ?></option>
                <?php endforeach; ?>
            </select>
        </h3>

        <div id="categorieCarousel" class="carousel slide" data-bs-interval="false">
            <div class="carousel-inner">
                <?php foreach (array_chunk($animeData, 5) as $index => $animeChunk) : ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="d-flex justify-content-center">
                            <?php foreach ($animeChunk as $anime): ?>
                                <div class="card text-center mx-2" style="min-width: 150px; max-width: 150px; border: 1px solid black; border-radius: 8px;">
                                    <img src="<?= $anime['coverImage']['large'] ?>" class="card-img-top" alt="<?= htmlspecialchars($anime['title']['romaji']) ?>" style="height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                    <div class="card-body" style="color: #000;">
                                        <h6 class="card-title" style="color: black;"><?= htmlspecialchars($anime['title']['romaji']) ?></h6>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#categorieCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#categorieCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>

    <style>
        .carousel-inner {
            display: flex;
            align-items: center;
            min-height: 300px;
        }

        .card {
            background-color: transparent;
            /* Fond 100% transparent */
            color: #eaeaea;
            border: 1px solid #0D6EFD;
        }
    </style>
<?php
}

afficherCategorieCarousel($animeData, $parsedown, $tr, $selectedGenre, $genres);
?>