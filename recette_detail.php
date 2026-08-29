<?php
require_once 'includes/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ?");
$stmt->execute([$id]);
$recette = $stmt->fetch();

if (!$recette) {
    header("Location: recettes.php");
    exit;
}

$page_css = "style-recette-detail.css";
require_once 'includes/header.php';
?>

    <section class="detail-page">

        <a href="recettes.php" class="btn-retour">← Retour aux recettes</a>

        <div class="detail-card">

            <div class="detail-icon">🍽️</div>
            <h1><?php echo htmlspecialchars($recette['nom']); ?></h1>
            <p class="detail-meta"><?php echo htmlspecialchars($recette['categorie']); ?> · <?php echo $recette['temps_preparation']; ?> min</p>

            <h2>Ingrédients</h2>
            <p class="detail-ingredients"><?php echo htmlspecialchars($recette['ingredients']); ?></p>

            <div class="detail-actions">
                <a href="modifier_recette.php?id=<?php echo $recette['id']; ?>" class="btn btn-primary">Modifier</a>
                <a href="supprimer_recette.php?id=<?php echo $recette['id']; ?>" class="btn-danger" onclick="return confirm('Supprimer cette recette ?');">Supprimer</a>
            </div>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>