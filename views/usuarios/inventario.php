<?php
require_once "controllers/usuariosController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new UsuariosController();
$user = "";
$campo = "";
$modo = "";

require_once "controllers/usuariosController.php";
if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}
$id = $_REQUEST['id'];   
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Tus Digimones</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <div>
            <!-- Este formulario es para ver todos los datos    -->
            <form action="index.php?tabla=usuarios&accion=buscar&evento=todos" method="POST">
                <button type="submit" class="btn btn-info" name="Todos"><i class="fas fa-list"></i> Listar</button>
            </form>
        </div>
        <?php
        if ($mostrarDatos) {
        ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Partidas Ganadas</th>
                        <th scope="col">Partidas Perdidas</th>
                        <th scope="col">Partidas totales</th>
                        <th scope="col">Ver Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) :
                        $id = $usuario->id;
                    ?>
                        <tr>
                            <th scope="row"><?= $usuario->id ?></th>
                            <td><?= $usuario->nombre ?></td>
                            <td><?= $usuario->partidas_ganadas ?></td>
                            <td><?= $usuario->partidas_perdidas ?></td>
                            <td><?= $usuario->partidas_totales ?></td>
                            <td scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=ver&id=<?= $usuario->id ?>&buscar=true"><i class="fa-solid fa-sitemap"></i> Ver Usuario</a></td>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <a href="index.php?tabla=usuarios&accion=administrar" class="btn btn-primary">Volver a Inicio</a>
        <?php
        }
        ?>
    </div>
</main>