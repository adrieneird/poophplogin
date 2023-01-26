<?php

require_once "class/user.php";
require_once "class/db.php";
require_once "class/form_login.php";

session_start();

$db = new Db();
$pdo = $db->getDb();

// Traitement des données formulaires
if (isset($_POST['login'])) {
    $form_login = new FormLogin();
    $form_login->process($pdo);
}

// Connecté ou non ?
$nickname = "";
if (isset($_SESSION['id'])) {
    // Récupération du nickname de l'user selon son ID
    $user = new User($_SESSION['id']);
    $nickname = $user->loadNickname($pdo);
}

?>
<html>
    <body>
<?php
    //On est connecté, on affiche bonjour
    if (isset($_SESSION['id'])) { 
?>
    Bonjour <?= $nickname ?> !
<?php 
    } else {
    // On n'est pas connecté, on affiche le formulaire
    include "views/form_login.html";
    }
?>
    </body>
</html>