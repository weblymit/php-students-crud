<?php
// on demarre une session
session_start();

require_once("helper/pdo.php");
include('helper/functions.php');
include("partials/_header.php");
$inputStyle = "border p-2 mt-1 mb-1 block w-full rounded-lg";

//1- recupère student avec le bon ID
if (!empty($_GET['id']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
  // On met $_GET['id'] dans une variable et on nettoit
  $id = trim(htmlspecialchars($_GET['id']));
  // Faire la requete
  $sql = "SELECT * FROM students WHERE id= :id";
  // prepare lA REQUETE
  $query = $pdo->prepare($sql);
  // Securise avec bindValue() pour projeter injection sql
  $query->bindValue(':id', $id, PDO::PARAM_INT);
  // Execute lA REQUETE
  $query->execute();
  // on recupere le produit
  $student = $query->fetch();
  // on vérifie si l'étudiant existe avec id
  if (!$student) {
    $_SESSION["error"] = "Cet étudiant n'existe pas !";
    header('Location: index.php');
  }
} else {
  $_SESSION["error"] = "Url invalide";
  header('Location: index.php');
}

?>
<div class="">
  <h1 class="text-3xl font-black text-center mb-8">Profile stagiaire</h1>
  <!-- <button onclick="history.back(1);" class="text-green-500">Back </button> -->
  <?php include("partials/_back.php") ?>
  <!-- <a href="<?php //echo $_SERVER['HTTP_REFERER'] ?>">Back</a> -->
  <div class=" max-w-lg text-lg mt-6">
    <p>Nom : <?= $student["fName"] . " " . $student["lName"] ?> </p>
    <p>Age : <?= $student["age"] ?> </p>
    <p>Formation : <?= $student["formation"] ?> </p>
    <p>Date d'entrée en formation :
      <?=
      $date = date("d/m/Y", strtotime($student['created_at']));
      ?>
    </p>
    <p>Dernière mis à jour :
      <?=
      $update = $student['updated_at'];
      $currentDat = date("Y-m-d H:i:s");
      $date = date("d/m/Y", strtotime($student['updated_at']));
      ?>
    </p>
  </div>
</div>

<!-- Footer -->
<?php
include("partials/_footer.php")
?>