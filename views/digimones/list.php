<?php
require_once "controllers/digimonesController.php";

$controlador = new DigimonesController();
$digimones = $controlador->listar();
$visibilidad = "hidden";
if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "borrar") {
    $visibilidad = "visibility";
    $clase = "alert alert-success";
    $mensaje = "El digimon con id: {$_REQUEST['id']}, usuario: {$_REQUEST['usuario']} y nombre: {$_REQUEST['nombre']}. Borrado correctamente";
    if (isset($_REQUEST["error"])) {
        $clase = "alert alert-danger ";
        $mensaje = "ERROR!!! No se ha podido borrar el digimon con id: {$_REQUEST['id']}";
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Listar Digimones</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <?php
        if (count($digimones) <= 0) :
            echo "No hay Datos a Mostrar";
        else : ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Ataque</th>
                        <th scope="col">Defensa</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">ID de evolucion</th>
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($digimones as $digimon) :
                        $id = $digimon->id;
                        $nombre = $digimon->nombre;
                    ?>
                        <tr>
                            <th scope="row"><?= $digimon->id ?></th>
                            <td><?= $digimon->nombre ?></td>
                            <td><?= $digimon->ataque ?></td>
                            <td><?= $digimon->defensa ?></td>
                            <td><?= $digimon->nivel ?></td>
                            <td><?= $digimon->evo_id ?></td>
                            <td><?= $digimon->tipo ?></td>
                            <td><a class="btn btn-danger" href="index.php?tabla=digimones&accion=borrar&id=<?= $id ?>&nombre=<?= $nombre ?>"><i class="fa fa-trash"></i> Borrar</a></td>
                            <td><a class="btn btn-success" href="index.php?tabla=digimones&accion=editar&id=<?= $id ?>"><i class="fas fa-pencil-alt"></i> Editar</a></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        <?php
        endif;
        ?>
    </div>
</main>