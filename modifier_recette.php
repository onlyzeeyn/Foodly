<?php
require_once 'includes/db.php';

$id = $_GET['id'];
$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $categorie = $_POST['categorie'];
    $temps = $_POST['temps'];
    $ingredients = trim($_POST['ingredients']);

    if ($nom === "") {
        $erreurs[] = "Le nom de la recette est obligatoire.";
    }

    if ($categorie === "") {
        $erreurs[] = "Merci de choisir une catégorie.";
    }

    if (!is_numeric($temps) || $temps <= 0) {
        $erreurs[] = "Le temps de préparation doit être un nombre supérieur à 0.";
    }

    if ($ingredients === "") {
        $erreurs[] = "La liste des ingrédients est obligatoire.";
    }

    if (count($erreurs) === 0) {
        $stmt = $pdo->prepare("UPDATE recettes SET nom = ?, categorie = ?, temps_preparation = ?, ingredients = ? WHERE id = ?");
        $stmt->execute([$nom, $categorie, $temps, $ingredients, $id]);

        header("Location: recette_detail.php?id=$id");
        exit;
    }

    // En cas d'erreur, on garde les valeurs tapées pour les réafficher
    $recette = [
        'id' => $id,
        'nom' => $nom,
        'categorie' => $categorie,
        'temps_preparation' => $temps,
        'ingredients' => $ingredients
    ];

} else {

    // Affichage initial : on va chercher la recette existante
    $stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ?");
    $stmt->execute([$id]);
    $recette = $stmt->fetch();

    if (!$recette) {
        header("Location: recettes.php");
        exit;
    }
}

$page_css = "style-ajouter-recette.css";
require_once 'includes/header.php';
?>

    <section class="form-page">

        <a href="recette_detail.php?id=<?php echo $recette['id']; ?>" class="btn-retour">← Retour à la recette</a>

        <div class="form-card">

            <h1>Modifier la recette</h1>

            <?php if (count($erreurs) > 0) { ?>
                <div class="form-erreurs">
                    <ul>
                        <?php foreach ($erreurs as $erreur) { ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form action="modifier_recette.php?id=<?php echo $recette['id']; ?>" method="POST">

                <label for="nom">Nom de la recette</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($recette['nom']); ?>">

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">Choisir une catégorie</option>
                    <option value="Petit-déj" <?php if ($recette['categorie'] === 'Petit-déj') echo 'selected'; ?>>Petit-déj</option>
                    <option value="Déjeuner" <?php if ($recette['categorie'] === 'Déjeuner') echo 'selected'; ?>>Déjeuner</option>
                    <option value="Dîner" <?php if ($recette['categorie'] === 'Dîner') echo 'selected'; ?>>Dîner</option>
                    <option value="Dessert" <?php if ($recette['categorie'] === 'Dessert') echo 'selected'; ?>>Dessert</option>
                </select>

                <label for="temps">Temps de préparation (minutes)</label>
                <input type="number" id="temps" name="temps" value="<?php echo htmlspecialchars($recette['temps_preparation']); ?>">

                <label for="ingredients">Ingrédients</label>
                <textarea id="ingredients" name="ingredients" rows="4"><?php echo htmlspecialchars($recette['ingredients']); ?></textarea>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>

            </form>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>