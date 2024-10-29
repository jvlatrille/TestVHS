<?php
// Emplacement du fichier JSON et du dossier d'images
$cacheFile = __DIR__ . '/infos.json';
$imageDir = __DIR__ . '/img/';

// Fonction principale pour vérifier et récupérer les données d'un anime
function getAnimeData($animeId) {
    global $cacheFile, $imageDir;

    // Charger les données du cache JSON
    $cacheData = file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : [];

    // Vérifier si l'ID est déjà dans le cache
    if (isset($cacheData[$animeId])) {
        return $cacheData[$animeId];
    }

    // Si l'ID n'est pas dans le cache, récupérer les données depuis AniList
    $animeData = fetchAnimeDataFromAPI($animeId);

    // Sauvegarder les informations dans le JSON
    $cacheData[$animeId] = $animeData;
    file_put_contents($cacheFile, json_encode($cacheData));

    // Télécharger l'image si elle n'existe pas déjà
    if (!file_exists($imageDir . $animeId . '.jpg')) {
        downloadImage($animeData['coverImage'], $imageDir . $animeId . '.jpg');
    }

    return $animeData;
}

// Fonction pour récupérer les données depuis AniList
function fetchAnimeDataFromAPI($animeId) {
    $query = <<<GRAPHQL
    query {
        Media(id: $animeId, type: ANIME) {
            id
            title {
                romaji
                english
                native
            }
            coverImage {
                large
            }
            description
            averageScore
            genres
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

    $data = json_decode($response, true);
    return $data['data']['Media'] ?? null;
}

// Fonction pour télécharger une image
function downloadImage($url, $path) {
    $image = file_get_contents($url);
    file_put_contents($path, $image);
}
?>
