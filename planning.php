<?php
require_once 'includes/db.php';

// Si un select a été changé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $jour = $_POST['jour'];
    $type_repas = $_POST['type_repas'];
    $id_recette = $_POST['id_recette'];

    if ($id_recette === '') {
        // L'utilisateur a choisi "+ choisir une recette" : on retire le créneau
        $stmt = $pdo->prepare("DELETE FROM planning WHERE jour = ? AND type_repas = ?");
        $stmt->execute([$jour, $type_repas]);

    } else {
        // On vérifie si un créneau existe déjà pour ce jour + ce type de repas
        $stmt = $pdo->prepare("SELECT id FROM planning WHERE jour = ? AND type_repas = ?");
        $stmt->execute([$jour, $type_repas]);
        $existant = $stmt->fetch();

        if ($existant) {
            // Le créneau existe déjà, on le met à jour
            $stmt = $pdo->prepare("UPDATE planning SET id_recette = ? WHERE id = ?");
            $stmt->execute([$id_recette, $existant['id']]);
        } else {
            // Le créneau n'existe pas encore, on le crée
            $stmt = $pdo->prepare("INSERT INTO planning (jour, type_repas, id_recette) VALUES (?, ?, ?)");
            $stmt->execute([$jour, $type_repas, $id_recette]);
        }
    }

    header("Location: planning.php");
    exit;
}

// On récupère toutes les recettes pour remplir les menus déroulants
$recettes = $pdo->query("SELECT id, nom FROM recettes ORDER BY nom ASC")->fetchAll();

// On récupère le planning existant
$stmt = $pdo->query("SELECT * FROM planning");
$planningBrut = $stmt->fetchAll();

// On organise le planning pour un accès facile : $planning['Lundi']['Midi'] = id de la recette
$planning = [];
foreach ($planningBrut as $ligne) {
    $planning[$ligne['jour']][$ligne['type_repas']] = $ligne['id_recette'];
}

$jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

$page_css = "style-planning.css";
require_once 'includes/header.php';
?>

    <section class="planning-page">

        <div class="planning-header">
            <h1>Mon planning</h1>
        </div>

        <div class="planning-list">

            <?php foreach ($jours as $jour) { ?>

                <div class="jour-card">
                    <h2><?php echo $jour; ?></h2>

                    <?php foreach (["Midi", "Soir"] as $type_repas) { ?>

                        <div class="creneau">
                            <span class="creneau-label"><?php echo $type_repas; ?></span>

                            <form action="planning.php" method="POST" class="creneau-form">
                                <input type="hidden" name="jour" value="<?php echo $jour; ?>">
                                <input type="hidden" name="type_repas" value="<?php echo $type_repas; ?>">

                                <select name="id_recette" class="creneau-select" onchange="this.form.submit()">
                                    <option value="">+ choisir une recette</option>
                                    <?php foreach ($recettes as $recette) { ?>
                                        <option value="<?php echo $recette['id']; ?>"
                                            <?php if (isset($planning[$jour][$type_repas]) && $planning[$jour][$type_repas] == $recette['id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($recette['nom']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </form>

                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>

    </section>

<?php require_once 'includes/footer.php'; ?>