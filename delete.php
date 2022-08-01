<?php
// On démarre une session
session_start();
//connect to db
require_once("helper/pdo.php");
//récuperation de l'id danss url
$id = trim(htmlspecialchars($_GET['id']));
// requete delete
$sql = "DELETE FROM students WHERE id=?";
//on prepare la requete
$stmt = $pdo->prepare($sql);
//on execute la requete
$stmt->execute([$id]);

//redirection
$_SESSION['success'] = "Etudiant supprimé !";
header("Location:index.php");
