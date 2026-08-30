<?php
require_once 'includes/db.php';

// On récupère toutes les recettes assignées dans le planning
$stmt = $pdo->query("
    SELECT recettes.ingredients 
    FROM planning 
    JOIN recettes ON planning.id_recette = recettes.id
");
$lignes = $stmt->fetchAll();

$compteurIngredients = [];

foreach ($lignes as $ligne) {
    $ingredientsRecette = explode(",", $ligne['ingredients']);

    foreach ($ingredientsRecette as $ingredient) {
        $ingredientPropre = trim(strtolower($ingredient));

        if (isset($compteurIngredients[$ingredientPropre])) {
            $compteurIngredients[$ingredientPropre]++;
        } else {
            $compteurIngredients[$ingredientPropre] = 1;
        }
    }
}

ksort($compteurIngredients);

$page_css = "style-liste-courses.css";
require_once 'includes/header.php';
?>

    <section class="courses-page">

        <div class="courses-header">
            <h1>Liste de courses</h1>
        </div>

        <div class="courses-card">

            <?php if (count($compteurIngredients) === 0) { ?>

                <p>Aucun ingrédient pour le moment. Remplissez votre planning !</p>

            <?php } else { ?>

                <ul class="courses-list">
                    <?php foreach ($compteurIngredients as $ingredient => $nombre) { ?>
                        <li>
                            <span class="ingredient-nom"><?php echo htmlspecialchars(ucfirst($ingredient)); ?></span>
                            <?php if ($nombre > 1) { ?>
                                <span class="ingredient-count"><?php echo $nombre; ?> recettes</span>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>

            <?php } ?>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>