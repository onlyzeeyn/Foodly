<?php
require_once 'includes/db.php';

$erreurs = [];
$nom = "";
$categorie = "";
$temps = "";
$ingredients = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $categorie = $_POST['categorie'];
    $temps = $_POST['temps'];
    $ingredients = trim($_POST['ingredients']);

    // Validation du nom
    if ($nom === "") {
        $erreurs[] = "Le nom de la recette est obligatoire.";
    }

    // Validation de la catégorie
    if ($categorie === "") {
        $erreurs[] = "Merci de choisir une catégorie.";
    }

    // Validation du temps
    if (!is_numeric($temps) || $temps <= 0) {
        $erreurs[] = "Le temps de préparation doit être un nombre supérieur à 0.";
    }

    // Validation des ingrédients
    if ($ingredients === "") {
        $erreurs[] = "La liste des ingrédients est obligatoire.";
    }

    // Si aucune erreur, on enregistre
    if (count($erreurs) === 0) {
        $stmt = $pdo->prepare("INSERT INTO recettes (nom, ingredients, temps_preparation, categorie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $ingredients, $temps, $categorie]);

        header("Location: recettes.php");
        exit;
    }
}

$page_css = "style-ajouter-recette.css";
require_once 'includes/header.php';
?>

    <section class="form-page">

        <a href="recettes.php" class="btn-retour">← Retour aux recettes</a>

        <div class="form-card">

            <h1>Ajouter une recette</h1>

            <?php if (count($erreurs) > 0) { ?>
                <div class="form-erreurs">
                    <ul>
                        <?php foreach ($erreurs as $erreur) { ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form action="ajouter_recette.php" method="POST">

                <label for="nom">Nom de la recette</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" placeholder="Ex: Poulet au curry">

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">Choisir une catégorie</option>
                    <option value="Petit-déj" <?php if ($categorie === 'Petit-déj') echo 'selected'; ?>>Petit-déj</option>
                    <option value="Déjeuner" <?php if ($categorie === 'Déjeuner') echo 'selected'; ?>>Déjeuner</option>
                    <option value="Dîner" <?php if ($categorie === 'Dîner') echo 'selected'; ?>>Dîner</option>
                    <option value="Dessert" <?php if ($categorie === 'Dessert') echo 'selected'; ?>>Dessert</option>
                </select>

                <label for="temps">Temps de préparation (minutes)</label>
                <input type="number" id="temps" name="temps" value="<?php echo htmlspecialchars($temps); ?>" placeholder="Ex: 30">

                <label for="ingredients">Ingrédients</label>
                <textarea id="ingredients" name="ingredients" rows="4" placeholder="Ex: riz, poulet, curry, lait de coco"><?php echo htmlspecialchars($ingredients); ?></textarea>

                <button type="submit" class="btn btn-primary">Enregistrer la recette</button>

            </form>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>