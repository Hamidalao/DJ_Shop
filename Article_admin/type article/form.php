<!DOCTYPE html>
<html>

<head>
    <title>Formulaire d'enregistrement des photos d'articles</title>
    <link rel="stylesheet" href="../Jquery compresse/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_css_bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Formulaire d'enregistrement des photos d'articles</h1>
        <form method="post" enctype="multipart/form-data" action="form_traitement.php">
            <div class="form-group">
                <label for="articleName">Nom de l'article</label>
                <input type="text" name="articleName" class="form-control">
            </div>
            <div class="form-group">
                <label for="image">Photo de l'article</label>
                <input type="file" name="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="articleType">Type d'article</label>
                <select name="articleType" class="form-control">
                    <option value=""></option>
                    <option value="tissu">Tissu</option>
                    <option value="sac">Sac</option>
                    <option value="chaussures">Chaussures</option>
                    <option value="montre">Montre</option>
                    <option value="femme">Femme</option>
                    <option value="homme">Homme</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Enregistrer</button>
            <a href="admin_affiche.php" class="btn btn-primary">Affichage</a>
        </form>
    </div>
</body>

</html>