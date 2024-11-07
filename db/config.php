<?php
// config.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vhsTEST";

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    echo "Échec de la connexion : " . $conn->connect_error;
}
?>
