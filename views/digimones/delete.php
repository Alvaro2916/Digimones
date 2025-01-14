<?php
require_once "controllers/digimonesController.php";
//pagina invisible
if (!isset ($_REQUEST["id"])){
   header('location:index.php' );
   exit();
}
//recoger datos
$id=$_REQUEST["id"];

$controlador= new DigimonesController();
$borrado=$controlador->borrar($id);