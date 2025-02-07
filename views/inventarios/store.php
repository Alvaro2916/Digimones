<?php
require_once "controllers/inventariosController.php";

//pagina invisible
$controlador = new InventariosController();
$controladorDigi = new DigimonesController();

$id = ($_REQUEST["id"]) ?? "";

$evo = $_REQUEST["id_Evo"] ?? "";

if($_REQUEST["evento"] !== "evolucionar"){
    $digimones = [
        "id_seleccionado" => $_REQUEST["id_seleccionado"],
        "id_noSeleccionado" => $_REQUEST["id_noSeleccionado"],
        "id_usuario" => $_REQUEST["id_usuario"],
    ];
}

if ($_REQUEST["evento"] == "cambiar") {
    $controlador->cambiarDigimones($digimones);
}

if ($_REQUEST["evento"] == "modificar") {
    $controlador->editar($id, $arrayUser);
}

if ($_REQUEST["evento"] == "evolucionar") {
    $controladorDigi->ver($evo);
}