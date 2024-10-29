<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); // Redirige vers l'accueil ou autre page après la déconnexion
exit();
