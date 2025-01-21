<?php
require_once "controllers/digimonesController.php";
if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}
$id = $_REQUEST['id'];
$controlador = new DigimonesController();
$digi = $controlador->ver($id);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Ver Digimon</h1>
    </div>
    <div id="contenido">
        <div class="card" style="width: 18rem;">
            <div>
                <h5 class="card-title">ID: <?= $digi->id ?> <br>NOMBRE: <?= $digi->nombre ?></h5>
                <p class="card-text">
                    <img src=assets/img/digimones/<?= $digi->nombre . "/" . $digi->imagen ?> width="100px"><br>
                    <img src=assets/img/digimones/<?= $digi->nombre . "/" . $digi->imagenV ?> width="100px"><br>
                    <img src=assets/img/digimones/<?= $digi->nombre . "/" . $digi->imagenD ?> width="100px"><br>
                    Nombre: <?= $digi->nombre ?><br>
                    Nivel: <?= $digi->nivel ?><br>
                    Tipo: <?= $digi->tipo ?><br>
                    Ataque: <?= $digi->ataque ?> -
                    Defensa: <?= $digi->defensa ?><br>
                    ID de la evolución: <?= $digi->evo_id ?><br>
                </p>
                <a class="btn btn-danger <?= $disable ?>" href="index.php?tabla=digimon&esaccion=borrar&id=<?= $id ?>"><i class="fa fa-trash"></i> Borrar</a>
                <a class="btn btn-success" href="index.php?tabla=digimones&accion=editar&id=<?= $id ?>"><i class="fa fa-pencil"></i>Editar</a>
                <a class="btn btn-primary" href="index.php?tabla=digimones&accion=evoluvcionar&id=<?= $_SESSION["usuario"]->id ?>">Definir Evoluciones</a>
                <?php
                if (isset($_REQUEST["buscar"])) {
                ?>
                    <a href="index.php?tabla=digimones&accion=buscar&evento=todos" class="btn btn-primary">Volver a Inicio</a>
                <?php
                } else {
                ?>
                    <a href="index.php?tabla=usuarios&accion=administrar" class="btn btn-primary">Volver a Inicio</a>
                <?php
                }
                ?>
            </div>
        </div>
</main>