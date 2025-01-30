<?php
require_once "controllers/inventariosController.php";

$id = ($_REQUEST["id"]) ?? "";

$digimones = [
    "id_seleccionado" => $_REQUEST["id_seleccionado"],
    "id_noSeleccionado" => $_REQUEST["id_noSeleccionado"],
    "id_usuario" => $_REQUEST["id_usuario"],
];

//pagina invisible
$controlador = new InventariosController();

if ($_REQUEST["evento"] == "cambiar") {
    $controlador->cambiarDigimones($digimones);
}

if ($_REQUEST["evento"] == "modificar") {
    $controlador->editar($id, $arrayUser);
}
