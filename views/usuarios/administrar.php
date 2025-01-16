<?php
ob_start();
require_once ("router/router.php");
$vista=router ();

if (!file_exists($vista)) "Error, REVISA TUS RUTAS";
else require_once ($vista);

$vista = router();

echo $vista;
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Juego Digimons </title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/404.css" rel="stylesheet">
</head>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administrando el programa</h1>
    </div>
    <div id="contenido">
        <table class="table table-light table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=ver&id=<?= $_SESSION["usuario"]->id ?>"><i class="fa-solid fa-sitemap"></i> Ver Usuario</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=buscar"><i class="fa-regular fa-eye"></i> Listar Usuario</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=crear&id=<?= $_SESSION["usuario"]->id ?>"><i class="fa-solid fa-hand-fist"></i> Dar de alta a un Digimon</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=evoluvcionar&id=<?= $_SESSION["usuario"]->id ?>"><i class="fa-solid fa-dna"></i> Definir Evoluciones</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=buscar&id=<?= $_SESSION["usuario"]->id ?>"><i class="fa-solid fa-gear"></i> Borrar Digimones</a></th>
                </tr>
            </thead>
        </table>
    </div>
    <div>
        <a href="index.php" class="btn btn-primary">Volver</a>
    </div>
</main>