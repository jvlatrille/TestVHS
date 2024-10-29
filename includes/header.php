<?php session_start(); ?>

<!-- header.php -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/custom.css">
    <title>VHS - Video Home Share</title>
</head>

<body>
    <header class="bg-dark text-light py-3">
        <nav class="navbar container">
            <!-- Logo et bouton Menu -->
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../img/logoSoulEater.png" alt="Logo" width="60" height="60" class="me-2">
                VHS
            </a>

            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#menuBar" aria-expanded="false" aria-controls="menuBar">
                Menu
            </button>

            <!-- Barre de recherche et Connexion/Langue -->
            <form class="d-flex ms-auto">
                <input class="form-control me-2" type="search" placeholder="Barre de recherche" aria-label="Search" style="max-width: 200px;">

                <!-- Bouton dynamique Connexion/Profil -->
                <?php if (isset($_SESSION['user'])) : ?>
                    <a href="../pages/profil.php" class="btn btn-outline-light me-2">Mon Profil</a>
                    <a href="../includes/logout.php" class="btn btn-outline-light me-2">Déconnexion</a>
                <?php else : ?>
                    <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="modal" data-bs-target="#authModal">Connexion</button>
                <?php endif; ?>

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
            </div>
        </div>
    </header>

    <!-- Modal de connexion / inscription -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Connexion / Inscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Onglets pour basculer entre Connexion et Inscription -->
                    <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Connexion</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Inscription</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="authTabsContent">
                        <!-- Formulaire de Connexion -->
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form action="../includes/login.php" method="POST">
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="loginEmail" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Connexion</button>
                            </form>
                        </div>

                        <!-- Formulaire d'Inscription -->
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form action="../includes/register.php" method="POST">
                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="registerEmail" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerUsername" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" id="registerUsername" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" id="registerPassword" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Créer un compte</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lien vers le fichier JavaScript Bootstrap local -->
    <script src="../js/bootstrap.js"></script>
</body>