<!-- header.php -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css"> <!-- Ton Bootstrap local -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Pour les petits ajustements -->
    <link rel="stylesheet" href="../css/custom.css"> <!-- Pour surcharger les couleurs -->

    <title>VHS - Video Home Share</title>
</head>

<body>
    <header class="bg-dark text-light py-3">
        <nav class="navbar container">
            <!-- Logo et bouton Menu -->
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                VHS
            </a>

            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#menuBar" aria-expanded="false" aria-controls="menuBar">
                Menu
            </button>

            <!-- Barre de recherche et Connexion/Langue -->
            <form class="d-flex ms-auto">
                <input class="form-control me-2" type="search" placeholder="Barre de recherche" aria-label="Search" style="max-width: 200px;">
                <button class="btn btn-outline-light me-2" type="button">Connexion</button>
                <button class="btn btn-outline-light" type="button">FR</button>
            </form>
        </nav>

        <!-- Menu déroulant sous le bouton "Menu" -->
        <div class="collapse" id="menuBar">
            <div class="container py-2 d-flex justify-content-center">
                <a href="forum.php" class="btn btn-light mx-2">Forum</a>
                <a href="watch2gather.php" class="btn btn-light mx-2">Watch2Gather</a>
                <a href="watchlist.php" class="btn btn-light mx-2">WatchList</a>
                <a href="quizz.php" class="btn btn-light mx-2">Quizz</a>
                <a href="profil.php" class="btn btn-light mx-2">Mon profil</a>
            </div>
        </div>
    </header>

    <!-- Lien vers le fichier JavaScript Bootstrap local -->
    <script src="../js/bootstrap.js"></script>
</body>
