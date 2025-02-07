<?php
require_once "controllers/digimonesController.php";
//recoger datos
if (!isset($_REQUEST["digimonBase"])) {
    header('Location:index.php?tabla=digimones&accion=buscar&evento=todos');
    exit();
}

$arrayDigimones = [
    "digimonBase" => $_REQUEST["digimonBase"],
    "digimonEvolucion" => $_REQUEST["digimonEvolucion"],
];

//pagina invisible
$controlador = new DigimonesController();

if ($_REQUEST["evento"] == "asignar") {
    $controlador->darEvolucion($arrayDigimones);
}
