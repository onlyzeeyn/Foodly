<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Fraunces:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <!-- Css -->
    <link rel="stylesheet" href="css/style-commun.css">
    <?php if (isset($page_css)) { ?>
        <link rel="stylesheet" href="css/<?php echo $page_css; ?>">
    <?php } ?>
    <title>Foodly | Planifiez vos repas</title>
</head>
<body>

    <nav>
        <a href="index.html" class="logo">Food<span>ly</span></a>
        <ul class="nav-links">
            <button class="close-menu hide" aria-label="Fermer le menu">✕</button>
            <li><a href="recettes.php">Mes recettes</a></li>
            <li><a href="planning.php">Mon planning</a></li>
            <li><a href="liste_courses.php">Liste de courses</a></li>
        </ul>

        <button class="hamburger" aria-label="Ouvrir le menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

<main>