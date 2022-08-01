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

// verifie que le bouton envoyer à bien éte cliquer
if (!empty($_POST["submited"])) {
  // Faille XXS On nettoie les données envoyées
  // =============
  $lName = trim(htmlspecialchars($_POST['lName']));
  $fName = trim(htmlspecialchars($_POST['fName']));
  $formation = trim(htmlspecialchars($_POST['formation']));
  $age = trim(htmlspecialchars($_POST['age']));

  // Validation form
  ////////////////////////
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
      $error['age'] = 'Age minimum est de 18';
    } elseif ($age > 67) {
      $error['age'] = 'Age maximum est de 66';
    }
  } else {
    $error["age"] = $errorMessage;
  }

  // if no error
  if (count($error) == 0) {
    $success = true;
    // Inserer une requette BBD
    // ecriture de la requette
    $sql = "INSERT INTO students(fName, lName, age, formation, created_at) VALUES(:fName, :lName, :age, :formation, NOW() )";
    // preparation de la requête
    $stmt = $pdo->prepare($sql);
    // Protection injections SQL
    $stmt->bindValue(':fName', $fName, PDO::PARAM_STR);
    $stmt->bindValue(':lName', $lName, PDO::PARAM_STR);
    $stmt->bindValue(':age', $age, PDO::PARAM_INT);
    $stmt->bindValue(':formation', $formation, PDO::PARAM_STR);

    // execution de la requête preparé
    $stmt->execute();
    // redirection vers page accueil
    $_SESSION["success"] = "Etudiant ajouté avec succès";
    header("Location: index.php");
    die;
  }
}

?>

<div class="">
  <h1 class="text-3xl font-black text-center mb-8">Ajouter un employé</h1>
  <div class=" bg-gray-100 max-w-lg">
    <form action="" class="rounded p-10" method="POST">
      <div class="mb-2">
        <label for="">Nom</label>
        <input type="text" name="lName" class="<?= $inputStyle ?>" value="<?php
                                                                          if (!empty($_POST['lName'])) {
                                                                            echo $_POST['lName'];
                                                                          }
                                                                          ?>">
        <span class="text-danger">
          <span class="text-red-500 text-xs">
            <?php if (!empty($error['lName'])) {
              echo $error['lName'];
            } ?>
          </span>
      </div>
      <div class="mb-2">
        <label for="">Prénom</label>
        <input type="text-danger" name="fName" class="<?= $inputStyle ?>" value="<?php
                                                                                  if (!empty($_POST['fName'])) {
                                                                                    echo $_POST['fName'];
                                                                                  }
                                                                                  ?>">
        <span class="text-red-500 text-xs">
          <?php if (!empty($error['fName'])) {
            echo $error['fName'];
          } ?>
        </span>
      </div>
      <div class="mb-2">
        <label for="">Formation</label>
        <input type="text" name="formation" class="<?= $inputStyle ?>" value="<?php
                                                                              if (!empty($_POST['formation'])) {
                                                                                echo $_POST['formation'];
                                                                              }
                                                                              ?>">
        <span class="text-red-500 text-xs">
          <?php if (!empty($error['formation'])) {
            echo $error['formation'];
          } ?>
        </span>
      </div>
      <div class="mb-2">
        <label for="">Age</label>
        <input type="number" name="age" class="<?= $inputStyle ?>" value="<?php
                                                                          if (!empty($_POST['age'])) {
                                                                            echo $_POST['age'];
                                                                          }
                                                                          ?>">
        <span class="text-red-500 text-xs">
          <?php if (!empty($error['age'])) {
            echo $error['age'];
          } ?>
        </span>
      </div>
      <input type="submit" name="submited" value="Envoyer" class="bg-blue-500 mt-4 w-full p-3 w-full text-white">
    </form>
  </div>
</div>

<?php
include("partials/_footer.php")
?>