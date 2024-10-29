<?php

/**
 * Vérifie et récupère les informations d'un anime par ID.
 * - Si les informations sont déjà dans infos.json, les retourne directement.
 * - Sinon, fait une requête à AniList, stocke les données dans infos.json, puis les retourne.
 */

function getAnimeData($id)
{
    $jsonFile = __DIR__ . '/infos.json';
    $imgFolder = __DIR__ . '/img';

    // Charger le fichier JSON existant, ou créer un nouveau tableau s'il est vide ou inexistant
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);
    } else {
        $data = [];
    }

    // Vérifie si l'ID est déjà dans le fichier JSON
    if (isset($data[$id])) {
        // echo "ID $id trouvé dans le cache.<br>";
        return $data[$id];
    }

    // ID non trouvé, récupération des données depuis AniList
    // echo "ID $id non trouvé, récupération depuis AniList.<br>";

    // Requête GraphQL pour récupérer les informations détaillées de l'anime
    $query = <<<GRAPHQL
    query {
        Media(id: $id, type: ANIME) {
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
            status
            studios {
                nodes {
                    name
                }
            }
            popularity
            trailer {
                id
                site
                thumbnail
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

    $animeData = json_decode($response, true)['data']['Media'] ?? null;

    if (!$animeData) {
        echo "Erreur : données non récupérées pour l'ID $id.<br>";
        return null;
    }

    // Télécharger et enregistrer l'image de couverture
    $imageUrl = $animeData['coverImage']['large'];
    $imagePath = "$imgFolder/$id.jpg";
    if (!file_exists($imagePath)) {
        file_put_contents($imagePath, file_get_contents($imageUrl));
    }

    // Mettre à jour le chemin de l'image locale dans les données de l'anime
    $animeData['coverImage']['local'] = "donnees/img/$id.jpg";

    // Stocker les données complètes dans le fichier JSON
    $data[$id] = $animeData;
    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo "Données de l'ID $id enregistrées dans infos.json avec l'image locale.<br>";

    return $animeData;
}
