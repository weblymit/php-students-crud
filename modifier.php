<?php
// on demarre une session
session_start();

//connect to db
require_once("helper/pdo.php");
include('helper/functions.php');
include("partials/_header.php");
$inputStyle = "border p-2 mt-1 mb-1 block w-full rounded-lg";

//formulaire
// Declartion  variable error
$error = array();
$success = false;
$errorMessage = "Ce champs est obligatoire";

//2- verifie que le bouton envoyer à bien éte cliquer
if (!empty($_POST["submited"])) {
  // Faille XXS
  // =============
  //ajoute ID
  $id = trim(htmlspecialchars($_POST['id'])); //Penser à ajouter input hidden for it
  $lName = trim(htmlspecialchars($_POST['lName']));
  $fName = trim(htmlspecialchars($_POST['fName']));
  $formation = trim(htmlspecialchars($_POST['formation']));
  $age = trim(htmlspecialchars($_POST['age']));

  // field id
  if (!empty($id)) {
    if (!is_numeric($id)) {
      $error['id'] = 'Veuillez rentrez un chiffre';
    }
  }
  //field fname
  if (!empty($fName)) {
    // vérifie nombre de caractère
    if (strlen($fName) < 4) {
      $error['fName'] = "Minimum 4 caractères";
    } elseif (strlen($fName) > 40) {
      $error['fName'] = "Maximum 40 caractères";
    }
  } else {
    $error["fName"] = $errorMessage;
  }
  //field fltname
  if (!empty($lName)) {
    // vérifie nombre de caractère
    if (strlen($lName) < 4) {
      $error['lName'] = "Minimum 4 caractères";
    } elseif (strlen($lName) > 40) {
      $error['lName'] = "Maximum 40 caractères";
    }
  } else {
    $error["lName"] = $errorMessage;
  }
  //field formation
  if (!empty($formation)) {
    // vérifie nombre de caractère
    if (strlen($formation) < 2) {
      $error['formation'] = "Minimum 2 caractères";
    } elseif (strlen($formation) > 20) {
      $error['formation'] = "Maximum 20 caractères";
    }
  } else {
    $error["formation"] = $errorMessage;
  }
  //field age
  if (!empty($age)) {
    if (!is_numeric($age)) {
      $error['age'] = 'Veuillez rentrez un chiffre';
    } elseif ($age < 18) {
      $error['population'] = 'Age minimum est de 18';
    } elseif ($age > 67) {
      $error['population'] = 'Age maximum est de 66';
    }
  } else {
    $error["age"] = $errorMessage;
  }

  // if no error
  if (count($error) == 0) {
    $success = true;
    // Inserer une requette BBD
    $sql = "UPDATE `students` SET `fName`= :fName, `lName` = :lName, `age`= :age, `formation`= :formation, `updated_at` = NOW() WHERE `id`= :id; ";
    // preparation de la requête
    $query = $pdo->prepare($sql);
    // Protection injections SQL
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':fName', $fName, PDO::PARAM_STR);
    $query->bindValue(':lName', $lName, PDO::PARAM_STR);
    $query->bindValue(':age', $age, PDO::PARAM_INT);
    $query->bindValue(':formation', $formation, PDO::PARAM_STR);

    // execution de la requête preparé
    $query->execute();
    // redirection vers page accueil
    header("Location: index.php");
    die;
  }
}

//1- recupère student avec le bon ID
if (!empty($_GET['id']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
  // On met $_GET['id'] dans une variable et on nettoit
  $id = trim(htmlspecialchars($_GET['id']));
  // On fait un select et verification avec bindValue
  $sql = "SELECT * FROM students WHERE id = :id";
  $query = $pdo->prepare($sql);
  // Securise avec bindValue() pour ne pas avoir injection sql
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
  <h1 class="text-3xl font-black text-center mb-8">Modifier un employé</h1>
  <div class=" bg-gray-100 max-w-lg">
    <form action="" class="rounded p-10" method="POST">
      <div class="mb-2">
        <label for="">Nom</label>
        <input type="text" name="lName" class="<?= $inputStyle ?>" value="<?= $student['lName'] ?>">
      </div>
      <div class="mb-2">
        <label for="">Prénom</label>
        <input type="text-danger" name="fName" class="<?= $inputStyle ?>" value="<?= $student['fName'] ?>">

      </div>
      <div class="mb-2">
        <label for="">Formation</label>
        <input type="text" name="formation" class="<?= $inputStyle ?>" value="<?= $student['formation'] ?>">
      </div>
      <div class="mb-2">
        <label for="">Age</label>
        <input type="number" name="age" class="<?= $inputStyle ?>" value="<?= $student['age'] ?>">
      </div>
      <!-- id -->
      <input type="hidden" name="id" value="<?= $student['id'] ?>">
      <input type="submit" name="submited" value="Modifier" class="bg-blue-500 mt-4 w-full p-3 w-full text-white">
    </form>
  </div>
</div>

<?php
include("partials/_footer.php")
?>