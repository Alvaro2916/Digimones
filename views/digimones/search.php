<?php
require_once "controllers/digimonesController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new DigimonesController();
$digimon = "";
$campo = "";
$modo = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $digimones = $controlador->listar();
            $mostrarDatos = true;
            break;
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "digimon";
            $metodo = ($_REQUEST["modo"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            $digimones = $controlador->buscar($campo, $metodo, $texto); //solo añadimos esto
            break;
        case "borrar":
            $visibilidad = "visibility";
            $mostrarDatos = true;
            $clase = "alert alert-success";
            //Mejorar y poner el nombre/usuario
            $mensaje = "El digimon con id: {$_REQUEST['id']} Borrado correctamente";
            if (isset($_REQUEST["error"])) {
                $clase = "alert alert-danger ";
                $mensaje = "ERROR!!! No se ha podido borrar el digimon con id: {$_REQUEST['id']}";
            }
            break;
    }
} ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Digimones</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <div>
            <form action="index.php?tabla=digimones&accion=buscar&evento=filtrar" method="POST">
                <div class="form-group">
                    <label for="usuario">Buscar Digimones</label><br>
                    <select class="form-select" aria-label="Default select example" id="campo" name="campo">
                        <option value="id">ID</option>
                        <option value="nombre" selected>Nombre</option>
                        <option value="ataque">Ataque</option>
                        <option value="defensa">Defensa</option>
                        <option value="nivel">Nivel</option>
                        <option value="tipo">Tipo</option>
                    </select>
                    <select class="form-select" aria-label="Default select example" id="modo" name="modo">
                        <option value="empieza" selected>Empieza Por</option>
                        <option value="acaba">Acaba En</option>
                        <option value="contiene">Contiene</option>
                        <option value="igual">Igual A</option>
                    </select>
                    <input type="text" required class="form-control" id="busqueda" name="busqueda" value="<?= $digimon ?>" placeholder="Buscar por Digimon">
                </div>
                <button type="submit" class="btn btn-success" name="Filtrar"><i class="fas fa-search"></i> Buscar</button>
            </form>
            <!-- Este formulario es para ver todos los datos    -->
            <form action="index.php?tabla=digimones&accion=buscar&evento=todos" method="POST">
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
                        <th scope="col">Ataque</th>
                        <th scope="col">Defensa</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Ver Digimon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($digimones as $digimon) :
                        $id = $digimon->id;
                    ?>
                        <tr>
                            <th scope="col"><?= $digimon->id ?></th>
                            <td><?= $digimon->nombre ?></td>
                            <td><?= $digimon->ataque ?></td>
                            <td><?= $digimon->defensa ?></td>
                            <td><?= $digimon->nivel ?></td>
                            <td><?= $digimon->tipo ?></td>
                            <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=ver&id=<?= $digimon->id ?>&buscar=true"><i class="fa-solid fas fa-eye"></i> Ver Digimon</a></th>
                        </tr>
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