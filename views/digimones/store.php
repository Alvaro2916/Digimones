<?php
require_once "controllers/digimonesController.php";
//recoger datos
if (!isset($_REQUEST["nombre"])) {
    header('Location:index.php?tabla=digimones&accion=crear');
    exit();
}

$id = ($_REQUEST["id"]) ?? ""; //el id me servirá en editar

$arrayUser = [
    "id" => $id,
    "nombre" => $_REQUEST["nombre"],
    "imagen" => $_FILES["imagen"],
    "imagenV" => $_FILES["imagenV"],
    "imagenD" => $_FILES["imagenD"],
    "ataque" => $_REQUEST["ataque"],
    "defensa" => $_REQUEST["defensa"],
    "nivel" => $_REQUEST["nivel"] ?? "1",
    "evo_id" => "0",
    "tipo" => $_REQUEST["tipo"],
];

//pagina invisible
$controlador = new DigimonesController();

if ($_REQUEST["evento"] == "crear") {
    $controlador->crear($arrayUser);
}

if ($_REQUEST["evento"] == "modificar") {
    $controlador->editar($id, $arrayUser);
}
