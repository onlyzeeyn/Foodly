<?php
$page_css = "style-ajouter-recette.css";
require_once 'includes/header.php';
?>

    <section class="form-page">

        <a href="recettes.php" class="btn-retour">← Retour aux recettes</a>

        <div class="form-card">

            <h1>Ajouter une recette</h1>

            <form action="#" method="POST">

                <label for="nom">Nom de la recette</label>
                <input type="text" id="nom" name="nom" placeholder="Ex: Poulet au curry" required>

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Choisir une catégorie</option>
                    <option value="Petit-déj">Petit-déj</option>
                    <option value="Déjeuner">Déjeuner</option>
                    <option value="Dîner">Dîner</option>
                    <option value="Dessert">Dessert</option>
                </select>

                <label for="temps">Temps de préparation (minutes)</label>
                <input type="number" id="temps" name="temps" placeholder="Ex: 30" required>

                <label for="ingredients">Ingrédients</label>
                <textarea id="ingredients" name="ingredients" rows="4" placeholder="Ex: riz, poulet, curry, lait de coco" required></textarea>

                <button type="submit" class="btn btn-primary">Enregistrer la recette</button>

            </form>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>