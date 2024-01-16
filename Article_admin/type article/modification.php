<?php
// Connexion à la base de données avec PDO
include "../config.php";
// Récupérer l'ID de la photo d'article à modifier depuis l'URL
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
} else {
    // Gérer l'erreur si l'ID n'est pas spécifié
    echo "ID de photo d'article non spécifié.";
    exit;
}

// Récupérer le type d'article et le nom de l'article depuis les paramètres d'URL
if (isset($_GET['type']) && isset($_GET['name'])) {
    $articleType = $_GET['type'];
    $articleName = $_GET['name'];
} else {
    // Gérer l'erreur si le type d'article et le nom d'article ne sont pas spécifiés
    echo "Type d'article ou nom d'article non spécifiés.";
    exit;
}

// Récupérer les données actuelles de la photo d'article
$query = $pdo->prepare("SELECT * FROM articles2 WHERE id = :id AND type = :type AND name = :name");
$query->execute(array(':id' => $articleId, ':type' => $articleType, ':name' => $articleName));
$article = $query->fetch(PDO::FETCH_ASSOC);

// Traitement de la modification de la photo d'article
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Assurez-vous de valider et sécuriser les données ici
    $newArticleName =$_POST['newArticleName'];

    // Vérification du type MIME de la nouvelle image
    $newImageMime = $_FILES['newImage']['type'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($newImageMime, $allowedMimeTypes)) {
        echo "Le type de fichier de la nouvelle image n'est pas autorisé.";
        exit;
    }

    // Chemin du répertoire où la nouvelle image sera stockée
    // $imagePath = 'ImgArticle3/' . $articleType . '/' . $newArticleName . '.jpg';
    $imagePath = 'ImgArticle3/' . $_FILES['newImage']['name'];

    // Mettre à jour les données dans la base de données
    $query = $pdo->prepare("UPDATE articles2 SET name = :newName, image = :newImage, type = :newType WHERE id = :id");
    $query->execute(array(':newName' => $newArticleName, ':newImage' => $imagePath, ':newType' => $articleType, ':id' => $articleId));

    // Télécharger la nouvelle image dans le répertoire
    move_uploaded_file($_FILES['newImage']['tmp_name'], $imagePath);

    // Rediriger l'utilisateur vers la page d'affichage des photos d'articles du type correspondant
    header('Location: afficher_toff.php?type=' . $articleType);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modifier la photo d'article - <?= $articleType ?> - <?= $articleName ?></title>
    <link rel="stylesheet" href="../Jquery compresse/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_css_bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Modifier la photo d'article - <?= $articleType ?> - <?= $articleName ?></h1>
        <div class="mb-3">
            <h3>Photo actuelle de l'article:</h3>
            <img src="<?= $article['image'] ?>" alt="<?= $article['name'] ?>" class="img-fluid">
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="newArticleName">Nouveau nom de l'article</label>
                <input type="text" name="newArticleName" class="form-control" value="<?= $article['name'] ?>">
            </div>
            <div class="form-group">
                <label for="newImage">Nouvelle photo de l'article</label>
                <input type="file" name="newImage" class="form-control-file">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>
</body>

</html>