<?php
require_once "controllers/inventariosController.php";

//pagina invisible
$controlador = new InventariosController();

$id = ($_REQUEST["id"]) ?? "";
$id_usuario = ($_REQUEST["id_usuario"]) ?? "";

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

if ($_REQUEST["evento"] == "evolucionar") {
    $controlador->evolucionarDigimon($id, $id_usuario);
}