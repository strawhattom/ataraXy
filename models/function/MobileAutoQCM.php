<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include("THEPHP.php");
$qcm = $_GET['qcm'];
        
$question = recup_question($qcm);
$reponse = recup_reponses($qcm);
$data = array(
    'question' => $question,
    'reponses' => $reponse,
    'message' => $question == "" AND count($reponse) == 0 ? false : true,
);

echo json_encode($data);

?>