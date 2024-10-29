<?php
session_start();

// Charger les données existantes des utilisateurs
$usersFile = $_SERVER['DOCUMENT_ROOT'] . '/PHP/TEST-VHS/pages/profil/infosUtilisateur.json';
$usersData = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Récupérer les données du formulaire de connexion
$email = $_POST['email'];
$password = $_POST['password'];

// Vérifier si l'utilisateur existe
if (!isset($usersData[$email])) {
    $_SESSION['message'] = "Identifiants incorrects.";
    header("Location: ../index.php");
    exit();
}

// Vérifier le mot de passe
if (!password_verify($password, $usersData[$email]['password'])) {
    $_SESSION['message'] = "Identifiants incorrects.";
    header("Location: ../index.php");
    exit();
}

// Ouvrir la session pour l'utilisateur
$_SESSION['user'] = [
    'email' => $email,
    'username' => $usersData[$email]['username']
];

$_SESSION['message'] = "Connexion réussie !";
header("Location: ../index.php");
exit();
?>
