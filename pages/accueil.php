<?php
include '../includes/header.php';
include '../db/config.php';
?>

<div class="container mt-5">
    <div class="jumbotron text-center bg-light text-dark">
        <h1 class="display-4 text-primary">Bienvenue sur VHS</h1>
        <p class="lead text-dark">Découvrez, partagez et discutez de vos films et séries préférés.</p>
        <hr class="my-4 border-dark">
        <p>Votre plateforme idéale pour tout amateur de cinéma.</p>
        <a class="btn btn-primary btn-lg" href="watchlist.php" role="button">Voir vos Watchlists</a>
        <a class="btn btn-secondary btn-lg" href="forum.php" role="button">Rejoindre le Forum</a>
    </div>
</div>


    <!-- Section Films Recommandés -->
    <section class="my-5">
        <h3 class="text-center mb-4">Films recommandés</h3>
        <div class="row">
            <?php
            $sql = "SELECT * FROM Film LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-3 mb-4">';
                    echo '<div class="card h-100">';
                    echo '<img src="../img/' . $row['image'] . '" class="card-img-top" alt="Image du film">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['titre'] . '</h5>';
                    echo '<p class="card-text">' . substr($row['description'], 0, 100) . '...</p>';
                    echo '</div>';
                    echo '<div class="card-footer">';
                    echo '<a href="page_film.php?id=' . $row['id'] . '" class="btn btn-primary">Voir plus</a>';
                    echo '</div></div></div>';
                }
            } else {
                echo "<p class='text-center'>Aucun film recommandé pour le moment.</p>";
            }
            ?>
        </div>
    </section>
</div>

<?php
include '../includes/footer.php';
$conn->close();
?>
