<?php
$serveur = "localhost";
$dbname = "formation";
$login = "root";
$password = "root"; // "root" or ""
try {
  $pdo = new PDO("mysql:host=$serveur;dbname=$dbname", $login, $password, array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    // Ne pas recuperer les éléments dupliqués
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // voir les erreur
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
  ));
  // echo "Connexion réussi";
} catch (PDOException $e) {
  echo 'Erreur de connexion : ' . $e->getMessage();
}
