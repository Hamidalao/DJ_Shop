<?php
//  session_start();
// Connexion à la base de données avec PDO
include "../config.php";

// Traitement de l'enregistrement des photos d'articles
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Assurez-vous de valider et sécuriser les données ici
    $articleName = $_POST['articleName'];

    $articleType = $_POST['articleType'];

    // Vérification de la taille maximale du fichier (par exemple, 5 Mo)
    $maxFileSize = 5 * 1024 * 1024; // 5 Mo en octets
    if ($_FILES['image']['size'] > $maxFileSize) {
        echo "Le fichier est trop volumineux. Veuillez choisir un fichier plus petit.";
    } else {
        // Vérification du type MIME
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileInfo = getimagesize($_FILES['image']['tmp_name']);
        if (!in_array($fileInfo['mime'], $allowedMimeTypes)) {
            echo "Le type de fichier n'est pas autorisé.";
        } else {
            // Génération d'un nom de fichier unique
            $uniqueFileName = uniqid() . '_' . $_FILES['image']['name'];
            $imagePath = 'ImgArticle3/' . $uniqueFileName;
  
            // Insérer les données dans la base de données en utilisant une requête préparée
            $query = $pdo->prepare("INSERT INTO articles2 (name, image, type) VALUES (:name, :image, :type)");
            $query->execute(array(':name' => $articleName, ':image' => $imagePath, ':type' => $articleType));

            // Code pour télécharger l'image dans le répertoire
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

           
            // $_SESSION['canEditDelete']=true;

            // Rediriger l'utilisateur vers la page d'affichage des photos d'articles correspondante
            header('Location: afficher_toff.php?type=' . $articleType);
        }
    }
}