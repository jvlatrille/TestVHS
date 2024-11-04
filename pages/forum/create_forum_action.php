<?php
// create_forum_action.php

// Chemin vers le fichier JSON
$forumFilePath = $_SERVER['DOCUMENT_ROOT'] . '/PHP/TEST-VHS/donnees/forum.json';

// Charger les données existantes depuis forum.json
$forumData = json_decode(file_get_contents($forumFilePath), true) ?? [];

// Créer un nouvel ID pour le forum
$newId = (isset($forumData) && count($forumData) > 0) ? end($forumData)['id'] + 1 : 1;

// Récupérer les informations du formulaire
$newForum = [
    'id' => $newId,
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'date_creation' => date("Y-m-d H:i:s"),
    'date_modification' => date("Y-m-d H:i:s")
];

// Ajouter le nouveau forum aux données existantes
$forumData[] = $newForum;

// Enregistrer les données mises à jour dans forum.json
file_put_contents($forumFilePath, json_encode($forumData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Rediriger vers la page forum.php après la création
header('Location: ../forum.php');
exit();
