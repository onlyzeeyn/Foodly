<?php
$page_css = "style-recette-detail.css";
require_once 'includes/header.php';
?>

    <section class="detail-page">

        <a href="recettes.php" class="btn-retour">← Retour aux recettes</a>

        <div class="detail-card">

            <div class="detail-icon">🍛</div>
            <h1>Poulet au curry</h1>
            <p class="detail-meta">Dîner · 30 min</p>

            <h2>Ingrédients</h2>
            <p class="detail-ingredients">Riz, poulet, curry, lait de coco, oignon, ail</p>

            <div class="detail-actions">
                <a href="modifier_recette.php?id=1" class="btn btn-primary">Modifier</a>
                <a href="#" class="btn-danger">Supprimer</a>
            </div>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>