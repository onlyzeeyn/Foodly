<?php
$page_css = "style-ajouter-recette.css";
require_once 'includes/header.php';
?>

    <section class="form-page">

        <a href="recette_detail.php?id=1" class="btn-retour">← Retour à la recette</a>

        <div class="form-card">

            <h1>Modifier la recette</h1>

            <form action="#" method="POST">

                <label for="nom">Nom de la recette</label>
                <input type="text" id="nom" name="nom" value="Poulet au curry" required>

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Choisir une catégorie</option>
                    <option value="Petit-déj">Petit-déj</option>
                    <option value="Déjeuner">Déjeuner</option>
                    <option value="Dîner" selected>Dîner</option>
                    <option value="Dessert">Dessert</option>
                </select>

                <label for="temps">Temps de préparation (minutes)</label>
                <input type="number" id="temps" name="temps" value="30" required>

                <label for="ingredients">Ingrédients</label>
                <textarea id="ingredients" name="ingredients" rows="4" required>Riz, poulet, curry, lait de coco, oignon, ail</textarea>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>

            </form>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>