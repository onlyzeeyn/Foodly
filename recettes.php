<?php
$page_css = "style-recettes.css";
require_once 'includes/db.php';
require_once 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM recettes ORDER BY id DESC");
$recettes = $stmt->fetchAll();
?>

    <section class="recettes-page">

        <div class="recettes-header">
            <h1>Mes recettes</h1>
            <div class="recettes-header-actions">
                <a href="decouvrir_recette.php" class="btn btn-secondary">🌍 Découvrir</a>
                <a href="ajouter_recette.php" class="btn btn-primary">+ Ajouter une recette</a>
            </div>
        </div>

        <div class="recettes-grid">

            <?php if (count($recettes) === 0) { ?>

                <p>Aucune recette pour le moment. Ajoutez-en une !</p>

            <?php } else { ?>

                <?php foreach ($recettes as $recette) { ?>

                    <a href="recette_detail.php?id=<?php echo $recette['id']; ?>" class="recette-card">
                        <div class="recette-icon">🍽️</div>
                        <h3><?php echo htmlspecialchars($recette['nom']); ?></h3>
                        <p class="recette-meta"><?php echo htmlspecialchars($recette['categorie']); ?> · <?php echo $recette['temps_preparation']; ?> min</p>
                        <p class="recette-ingredients">📝 <?php echo substr_count($recette['ingredients'], ',') + 1; ?> ingrédients</p>
                    </a>

                <?php } ?>

            <?php } ?>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>