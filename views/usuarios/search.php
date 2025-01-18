<?php
require_once "controllers/digimonesController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new UsuariosController();
$user = "";
$campo = "";
$modo = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $usuarios = $controlador->listar();
            $mostrarDatos = true;
            break;
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "nombre";
            $metodo = ($_REQUEST["modo"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            $usuarios = $controlador->buscar($campo, $metodo, $texto); //solo añadimos esto
            break;
    }
} ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Usuario</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <div>
            <form action="index.php?tabla=usuarios&accion=buscar&evento=filtrar" method="POST">
                <div class="form-group">
                    <label for="usuario">Buscar Usuario</label><br>
                    <select class="form-select" aria-label="Default select example" id="campo" name="campo">
                        <option value="id">ID</option>
                        <option value="nombre" selected>Nombre</option>
                        <option value="partidas_ganadas">Partidas Ganadas</option>
                        <option value="partidas_perdidas">Partidas Perdidas</option>
                        <option value="partidas_totales">Partidas Totales</option>
                    </select>
                    <select class="form-select" aria-label="Default select example" id="modo" name="modo">
                        <option value="empieza" selected>Empieza Por</option>
                        <option value="acaba">Acaba En</option>
                        <option value="contiene">Contiene</option>
                        <option value="igual">Igual A</option>
                    </select>
                    <input type="text" required class="form-control" id="busqueda" name="busqueda" value="<?= $user ?>" placeholder="Buscar por Usuario">
                </div>
                <button type="submit" class="btn btn-success" name="Filtrar"><i class="fas fa-search"></i> Buscar</button>
            </form>
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
                            <td scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=ver&id=<?= $usuario->id ?>"><i class="fa-solid fa-sitemap"></i> Ver Usuario</a></td>
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