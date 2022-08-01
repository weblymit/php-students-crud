<?php
// on demarre une session
session_start();
// redirection if is not connect
if (!$_SESSION['username']) {
  header("Location: login.php");
}
//connect to db
require_once("helper/pdo.php");
include('helper/functions.php');
include("partials/_header.php");

// Selectionner Requette
$sql = "SELECT * FROM students ORDER BY lName ";
// 1- Prépare la requette (preformatter)
$query = $pdo->prepare($sql);

// 2- Execute la requette
$query->execute();

// 3- On stock le resultat dans une variable
$students = $query->fetchAll();
?>
<div class="">
  <?php echo ($_SESSION["is_admin"] = 1) ? "hello admin" : "hellp" ?>
  <a href="logout.php" class="btn btn-primary">Déconnexion</a>

  <!-- alert -->
  <div class="">
    <?php
    if (!empty($_SESSION["error"])) { ?>
      <div class="alert alert-error shadow-lg mb-8" role="alert">
        <?= $_SESSION["error"] ?>
      </div>
    <?php } elseif (!empty($_SESSION["success"])) { ?>
      <div class="bg-green-400 text-white p-2 mb-8" role="alert">
        <?= $_SESSION["success"] ?>
      </div>
    <?php

    } else {
      echo "";
    }  // une fois msg affiché on reinitilaise la session et ses variables
    $_SESSION["error"] = "";
    $_SESSION["success"] = ""; ?>
  </div>
  <h1 class="font-black text-4xl pb-8">Liste des étudiants</h1>
  <span class="bg-green-500 p-3 text-white rounded shadow"><a href="addStudent.php">Ajouter stagiaire</a></span>
  <div class="mt-5">
    <table class="border-collapse border border-slate-400 w-full text-center">
      <thead class="bg-gray-100 h-12">
        <tr class="">
          <th class="border border-slate-300">Nom</th>
          <th class="border border-slate-300">Prénom</th>
          <th class="border border-slate-300">Age</th>
          <th class="border border-slate-300">Formation</th>
          <th class="border border-slate-300">Voir</th>
          <th class="border border-slate-300">Date d'entrée</th>
          <th class="border border-slate-300">Modifier</th>
          <th class="border border-slate-300">Etat</th>
          <th class="border border-slate-300">Supprimer</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (count($students) < 1) : ?>
          <tr class="h-14">
            <p>Pas de stagiaire actuellement</p>
          </tr>
        <?php else : ?>
          <?php foreach ($students as $student) : ?>
            <tr class="h-14">
              <td class="border border-slate-300"><?php echo $student["lName"] ?> </td>
              <td class="border border-slate-300"><?php echo $student["fName"] ?></td>
              <td class="border border-slate-300"><?php echo $student["age"] ?></td>
              <td class="border border-slate-300"><?php echo $student["formation"] ?></td>
              <td class="border border-slate-300">
                <a href="detail.php?id=<?php echo $student["id"] ?>&name=<?php echo $student["fName"] . '_' . $student["lName"] ?>" class="underline text-blue-600">
                  Voir
                </a>
              </td>
              <td class="border border-slate-300">
                <?=
                $date = date("d/m/Y", strtotime($student['created_at']));
                ?>
              </td>
              <td class="border border-slate-300">
                <a href="modifier.php?id=<?php echo $student["id"] ?>&name=<?php echo $student["fName"] . '_' . $student["lName"] ?>" class="">
                  <img src="./img/pen.png" alt="" class="w-6 mx-auto">
                </a>
              </td>
              <td class="border border-slate-300">
                <p><?= $student['actif'] == 1 ? "actif" : "inactif" ?></p>
                <a href="disable.php?id=<?php echo $student["id"] ?>&name=<?php echo $student["fName"] . '_' . $student["lName"] ?>">A/D</a>
              </td>

              <td class="border border-slate-300">
                <a href="delete.php?id=<?php echo $student["id"] ?>&name=<?php echo $student["fName"] . '_' . $student["lName"] ?>" class="">
                  <img src="./img/trash.png" alt="" class="w-6 mx-auto">
                </a>
              </td>
            </tr>
          <?php endforeach  ?>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>
<?php
include("partials/_footer.php")
?>