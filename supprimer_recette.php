<?php
require_once 'includes/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM recettes WHERE id = ?");
$stmt->execute([$id]);

header("Location: recettes.php");
exit;