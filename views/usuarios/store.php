<?php
require_once "controllers/usuariosController.php";
//recoger datos
if (!isset($_REQUEST["nombre"])) {
    header('Location:index.php?tabla=usuarios&accion=crear');
    exit();
}

$id = ($_REQUEST["id"]) ?? ""; //el id me servirá en editar

$arrayUser = [
    "id" => $id,
    "nombre" => $_REQUEST["nombre"],
    "imagen" => $_FILES["imagen"],
    "partidas_ganadas" => $_REQUEST["partidas_ganadas"],
    "partidas_perdidas" => $_REQUEST["partidas_perdidas"],
    "partidas_totales" => $_REQUEST["partidas_totales"],
    "permisos" => $_REQUEST["permisos"],
    "contrasenya" => $_REQUEST["contrasenya"],
    "digi_evu" => $_REQUEST["digi_evu"],
];

//pagina invisible
$controlador = new UsuariosController();

if ($_REQUEST["evento"] == "crear") {
    $controlador->crear($arrayUser);
}

if ($_REQUEST["evento"] == "modificar") {
    $controlador->editar($id, $arrayUser);
}
