<?php

include("dbconfig.php");

try {
    $bdd = new PDO('mysql:host='.$hostname.';dbname=$'.$dbname.';charset=utf8', $user, $pw);
}
catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');
 
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

$login = $obj['login'];
$pw = $obj['pw'];

$req = $bdd->prepare("SELECT * FROM `users` WHERE `LOGIN`=:id AND `MDP`=SHA1(:pw)");
$req->bindValue("id",$login);
$req->bindValue("pw",$pw);
$req->execute();

$result = $req->fetch(PDO::FETCH_ASSOC);

if ($result == false){
    $msg = "Erreur de connexion, l'identifiant ou le mot de passe est incorrect";
    echo json_encode($msg);
} else {
    $msg = true;
    echo json_encode($msg);
}

$req->closeCursor();
?>