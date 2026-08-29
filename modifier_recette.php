<?php
require_once 'includes/db.php';

$id = $_GET['id'];

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $temps = $_POST['temps'];
    $ingredients = $_POST['ingredients'];

    $stmt = $pdo->prepare("UPDATE recettes SET nom = ?, categorie = ?, temps_preparation = ?, ingredients = ? WHERE id = ?");
    $stmt->execute([$nom, $categorie, $temps, $ingredients, $id]);

    header("Location: recette_detail.php?id=$id");
    exit;
}

// Sinon, on va chercher la recette existante pour pré-remplir le formulaire
$stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ?");
$stmt->execute([$id]);
$recette = $stmt->fetch();

if (!$recette) {
    header("Location: recettes.php");
    exit;
}

$page_css = "style-ajouter-recette.css";
require_once 'includes/header.php';
?>

    <section class="form-page">

        <a href="recette_detail.php?id=<?php echo $recette['id']; ?>" class="btn-retour">← Retour à la recette</a>

        <div class="form-card">

            <h1>Modifier la recette</h1>

            <form action="modifier_recette.php?id=<?php echo $recette['id']; ?>" method="POST">

                <label for="nom">Nom de la recette</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($recette['nom']); ?>" required>

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Choisir une catégorie</option>
                    <option value="Petit-déj" <?php if ($recette['categorie'] === 'Petit-déj') echo 'selected'; ?>>Petit-déj</option>
                    <option value="Déjeuner" <?php if ($recette['categorie'] === 'Déjeuner') echo 'selected'; ?>>Déjeuner</option>
                    <option value="Dîner" <?php if ($recette['categorie'] === 'Dîner') echo 'selected'; ?>>Dîner</option>
                    <option value="Dessert" <?php if ($recette['categorie'] === 'Dessert') echo 'selected'; ?>>Dessert</option>
                </select>

                <label for="temps">Temps de préparation (minutes)</label>
                <input type="number" id="temps" name="temps" value="<?php echo $recette['temps_preparation']; ?>" required>

                <label for="ingredients">Ingrédients</label>
                <textarea id="ingredients" name="ingredients" rows="4" required><?php echo htmlspecialchars($recette['ingredients']); ?></textarea>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>

            </form>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>