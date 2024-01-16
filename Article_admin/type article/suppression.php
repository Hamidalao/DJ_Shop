<?php
// Connexion à la base de données avec PDO
include "../config.php";
// Récupérer l'ID de la photo d'article à supprimer depuis l'URL
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
} else {
    // Gérer l'erreur si l'ID n'est pas spécifié
    echo "ID de photo d'article non spécifié.";
    exit;
}

// Récupérer le type d'article depuis les paramètres d'URL
if (isset($_GET['type'])) {
    $articleType = $_GET['type'];
} else {
    // Gérer l'erreur si le type d'article n'est pas spécifié
    echo "Type d'article non spécifié.";
    exit;
}

// Récupérer les données actuelles de la photo d'article
$query = $pdo->prepare("SELECT * FROM articles2 WHERE id = :id AND type = :type");
$query->execute(array(':id' => $articleId, ':type' => $articleType));
$article = $query->fetch(PDO::FETCH_ASSOC);

// Traitement de la suppression de la photo d'article
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    // Supprimer l'entrée de la base de données
    $deleteQuery = $pdo->prepare("DELETE FROM articles2 WHERE id = :id AND type = :type");
    $deleteQuery->execute(array(':id' => $articleId, ':type' => $articleType));

    // Supprimer le fichier image du répertoire
    unlink($article['image']);

    // Rediriger l'utilisateur vers la page d'affichage des photos d'articles du type correspondant
    header('Location: afficher_toff.php?type=' . $articleType);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Supprimer la photo d'article - <?= $articleType ?></title>
    <link rel="stylesheet" href="../Jquery compresse/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_css_bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Supprimer la photo d'article - <?= $articleType ?></h1>
        <div class="mb-3">
            <h3>Photo de l'article à supprimer:</h3>
            <img src="<?= $article['image'] ?>" alt="<?= $article['name'] ?>" class="img-fluid">
        </div>
        <p>Êtes-vous sûr de vouloir supprimer cette photo d'article?</p>
        <form method="post">
            <button type="submit" name="confirm" class="btn btn-danger">Confirmer la suppression</button>
        </form>
    </div>
</body>

</html>