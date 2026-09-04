<?php
require_once 'includes/db.php';

// Fonction qui traduit un texte de l'anglais vers le français via MyMemory
function traduire($texte) {
    $texteEncode = urlencode($texte);
    $url = "https://api.mymemory.translated.net/get?q=$texteEncode&langpair=en|fr";
    
    $reponse = @file_get_contents($url);
    
    if ($reponse === false) {
        return $texte; // Si la traduction échoue, on garde le texte original
    }
    
    $donnees = json_decode($reponse, true);
    return $donnees['responseData']['translatedText'] ?? $texte;
}

$erreurs = [];

// Si on importe la recette dans notre base
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $categorie = $_POST['categorie'];
    $temps = $_POST['temps'];
    $ingredients = trim($_POST['ingredients']);

    if ($nom === "") $erreurs[] = "Le nom est obligatoire.";
    if ($categorie === "") $erreurs[] = "Merci de choisir une catégorie.";
    if (!is_numeric($temps) || $temps <= 0) $erreurs[] = "Le temps doit être un nombre supérieur à 0.";
    if ($ingredients === "") $erreurs[] = "Les ingrédients sont obligatoires.";

    if (count($erreurs) === 0) {
        $stmt = $pdo->prepare("INSERT INTO recettes (nom, ingredients, temps_preparation, categorie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $ingredients, $temps, $categorie]);

        header("Location: recettes.php");
        exit;
    }

    $recetteAPI = [
        'nom' => $nom,
        'ingredients' => $ingredients
    ];

} else {

    // On appelle l'API TheMealDB pour récupérer une recette aléatoire
    $reponseAPI = file_get_contents("https://www.themealdb.com/api/json/v1/1/random.php");
    $donnees = json_decode($reponseAPI, true);
    $meal = $donnees['meals'][0];

    // On rassemble les ingrédients (juste les noms, sans quantité, pour rester cohérent avec le reste du site)
    $listeIngredients = [];
    for ($i = 1; $i <= 20; $i++) {
        $ingredient = $meal["strIngredient$i"];

        if (trim($ingredient) !== "") {
            $listeIngredients[] = trim($ingredient);
        }
    }
    $ingredientsTexte = implode(", ", $listeIngredients);

    // Traduction du nom et des ingrédients
    $nomTraduit = traduire($meal['strMeal']);
    $ingredientsTraduits = traduire($ingredientsTexte);

    $recetteAPI = [
        'nom' => $nomTraduit,
        'ingredients' => $ingredientsTraduits,
        'image' => $meal['strMealThumb']
    ];
}

$page_css = "style-ajouter-recette.css";
require_once 'includes/header.php';
?>

    <section class="form-page">

        <a href="recettes.php" class="btn-retour">← Retour aux recettes</a>

        <div class="form-card">

            <h1>🌍 Découvrir une recette</h1>
            <p class="decouvrir-sous-titre">Recette suggérée depuis TheMealDB (traduite automatiquement) — modifiez-la si besoin avant de l'importer.</p>

            <?php if (count($erreurs) > 0) { ?>
                <div class="form-erreurs">
                    <ul>
                        <?php foreach ($erreurs as $erreur) { ?>
                            <li><?php echo htmlspecialchars($erreur); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <?php if (isset($recetteAPI['image'])) { ?>
                <img src="<?php echo htmlspecialchars($recetteAPI['image']); ?>" alt="" class="decouvrir-image">
            <?php } ?>

            <form action="decouvrir_recette.php" method="POST">

                <label for="nom">Nom de la recette</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($recetteAPI['nom']); ?>">

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">Choisir une catégorie</option>
                    <option value="Petit-déj">Petit-déj</option>
                    <option value="Déjeuner">Déjeuner</option>
                    <option value="Dîner">Dîner</option>
                    <option value="Dessert">Dessert</option>
                </select>

                <label for="temps">Temps de préparation (minutes)</label>
                <input type="number" id="temps" name="temps" value="30">

                <label for="ingredients">Ingrédients</label>
                <textarea id="ingredients" name="ingredients" rows="5"><?php echo htmlspecialchars($recetteAPI['ingredients']); ?></textarea>

                <button type="submit" class="btn btn-primary">Importer cette recette</button>

            </form>

            <a href="decouvrir_recette.php" class="btn-retour decouvrir-autre">🔄 Essayer une autre recette</a>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>