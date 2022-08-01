<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
  require_once("helper/pdo.php");

  // On nettoie l'id envoyé
  $id = trim(htmlspecialchars($_GET['id']));

  $sql = 'SELECT * FROM `students` WHERE `id` = :id;';
  // On prépare la requête
  $query = $pdo->prepare($sql);
  // On "accroche" les paramètre (id)
  $query->bindValue(':id', $id, PDO::PARAM_INT);
  // On exécute la requête
  $query->execute();
  // On récupère le student
  $student = $query->fetch();
  // On vérifie si le student existe
  if (!$student) {
    $_SESSION['erreur'] = "Cet id n'existe pas";
    header('Location: index.php');
  }

  $actif = ($student['actif'] == 0) ? 1 : 0;

  $sql = 'UPDATE `students` SET `actif`=:actif WHERE `id` = :id;';

  // On prépare la requête
  $query = $pdo->prepare($sql);
  // On "accroche" les paramètres
  $query->bindValue(':id', $id, PDO::PARAM_INT);
  $query->bindValue(':actif', $actif, PDO::PARAM_INT);
  // On exécute la requête
  $query->execute();

  header('Location: index.php');
} else {
  $_SESSION['erreur'] = "URL invalide";
  header('Location: index.php');
}
