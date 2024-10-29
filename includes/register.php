<?php
session_start();

// Charger les données existantes des utilisateurs
$usersFile = $_SERVER['DOCUMENT_ROOT'] . '/PHP/TEST-VHS/pages/profil/infosUtilisateur.json';
$usersData = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Récupérer les données du formulaire d'inscription
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Vérifier si l'email existe déjà
if (isset($usersData[$email])) {
    $_SESSION['message'] = "Cet email est déjà utilisé.";
    header("Location: ../index.php");
    exit();
}

// Hacher le mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Enregistrer les informations de l'utilisateur
$usersData[$email] = [
    'username' => $username,
    'password' => $hashedPassword,
    'created_at' => date("Y-m-d H:i:s")
];

// Sauvegarder les données mises à jour
file_put_contents($usersFile, json_encode($usersData, JSON_PRETTY_PRINT));

// Confirmation de l'inscription
$_SESSION['message'] = "Compte créé avec succès !";
header("Location: ../index.php");
exit();
?>
