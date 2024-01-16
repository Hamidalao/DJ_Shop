<?php
 session_start();
include "../config.php";

// Récupérer le type d'article depuis les paramètres d'URL
if (isset($_GET['type'])) {
    $articleType = $_GET['type'];
} else {
    // Gérer l'erreur si le type d'article n'est pas spécifié
    echo "Type d'article non spécifié.";
    exit;
}

// Récupérer les photos d'articles du type spécifique depuis la base de données
$query = $pdo->prepare("SELECT * FROM articles2 WHERE type = :type");
$query->execute(array(':type' => $articleType));
$articles = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Affichage des photos d'articles - <?= $articleType ?></title>
    <link rel="stylesheet" href="../Jquery compresse/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_css_bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Affichage des photos d'articles - <?= $articleType ?></h1>
        <p><a href="../../index.php" class="btn btn-secondary">Retour</a></p>
        <div class="row">
            <?php foreach ($articles as $article): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= $article['image'] ?>" class="card-img-top" alt="<?= $article['name'] ?>" width="200"
                        height="200">
                    <div class="card-body">
                        <h5 class="card-title"><?= $article['name'] ?></h5>


                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>