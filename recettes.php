<?php
$page_css = "style-recettes.css";
require_once 'includes/header.php';
?>

    <section class="recettes-page">

        <div class="recettes-header">
            <h1>Mes recettes</h1>
            <a href="ajouter_recette.php" class="btn btn-primary">+ Ajouter une recette</a>
        </div>

        <div class="recettes-grid">

            <a href="recette_detail.php?id=1" class="recette-card">
                <div class="recette-icon">🍛</div>
                <h3>Poulet au curry</h3>
                <p class="recette-meta">Dîner · 30 min</p>
                <p class="recette-ingredients">📝 6 ingrédients</p>
            </a>

            <a href="recette_detail.php?id=2" class="recette-card">
                <div class="recette-icon">🥗</div>
                <h3>Salade César</h3>
                <p class="recette-meta">Déjeuner · 15 min</p>
                <p class="recette-ingredients">📝 4 ingrédients</p>
            </a>

            <a href="recette_detail.php?id=3" class="recette-card">
                <div class="recette-icon">🥞</div>
                <h3>Pancakes</h3>
                <p class="recette-meta">Petit-déj · 20 min</p>
                <p class="recette-ingredients">📝 5 ingrédients</p>
            </a>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>