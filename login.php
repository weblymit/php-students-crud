<?php
session_start();

require_once("helper/pdo.php");
include('helper/functions.php');
include("partials/_header.php");

// $pass = "";
// echo password_hash($pass, PASSWORD_BCRYPT);

// $hash=password_hash($pass, PASSWORD_BCRYPT);

// echo password_verify($pass,$hash);

// verifie que le bouton envoyer à bien éte cliquer
if (!empty($_POST["submited"])) {
  $user_name = trim(htmlspecialchars($_POST['user_name']));
  $user_pswd = trim(htmlspecialchars($_POST['user_pswd']));

  // verifie si ce n'est pas vide
  if (
    !empty($_POST["user_name"]) &&
    !empty($_POST["user_pswd"])
  ) {

    // $user_name_defaut = "admin";
    // $user_pswd_defaut = "admin";
    $username = $_POST["user_name"];
    $password = $_POST["user_pswd"];

    // recupere les id et pswd
    $sql = "SELECT * FROM users WHERE user_name = :name ";
    // prepare lA REQUETE
    $query = $pdo->prepare($sql);
    // Securise avec bindValue() pour projeter injection sql
    $query->bindValue(':name', $username, PDO::PARAM_STR);
    // Execute lA REQUETE
    $query->execute();
    // on recupere le user
    $student = $query->fetch();

    // 1- verifie qu'il y a un user
    // 2- match pswd and hash pswd
    if ($student) {
      if (password_verify($password, $student['user_password'])) {
        $_SESSION["username"] = $username;
        $_SESSION["isADmin"] = $student["is_admin"];
        header('Location: index.php');
      } else {
        echo "identifiant ou mdp incorrect";
      }
    } else {
      echo "L'utilisateur n'existe pas";
    }
    // debug($student);

    // verifie user_pswd et user_name match
    // if ($user_name_defaut == $user_name && $user_pswd_defaut == $user_pswd) {
    //   $_SESSION["user_pswd"] = $user_pswd;
    //   header('Location:index.php');
    // } else {
    //   echo "votre mot de passe et user_name et incorrect";
    // }
  } else {
    echo "Champs obligatoires";
  }
}
?>
<main>
  <h1 class="font-black text-4xl pb-8">Connexion</h1>
  <form action="" method="POST">
    <div class="form-control w-full max-w-xs">
      <label class="label">
        <span class="label-text">Identifiant</span>
      </label>
      <input type="text" name="user_name" placeholder="pseudo" class="input input-bordered w-full max-w-xs" />
    </div>
    <div class="form-control w-full max-w-xs">
      <label class="label">
        <span class="label-text">Password</span>
      </label>
      <input type="password" name="user_pswd" placeholder="**********" class="input input-bordered w-full max-w-xs" />
    </div>
    <input type="submit" value="Envoyer" name="submited" class="btn bg-blue-500 mt-2" />
  </form>
</main>