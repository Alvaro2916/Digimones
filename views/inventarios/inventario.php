<?php
require_once "controllers/usuariosController.php";
require_once "controllers/digimonesController.php";
require_once "controllers/inventariosController.php";

$id = $_REQUEST['id'];
$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = true;
$controlador = new UsuariosController();
$usuario = $controlador->ver($id);
$controladorInv = new InventariosController();
$seleccionados = $controladorInv->buscarDigimonesSelec($usuario);
$digimonesSelec = "";
$digimonesNOSelec = "";

if (isset($_REQUEST["evento"])) {
    switch ($_REQUEST["evento"]) {
        case "todos":
            $digimones = $controladorInv->listarUsu($usuario);
            break;
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "nombre";
            $metodo = ($_REQUEST["modo"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            $digimones = $controladorInv->buscar($campo, $metodo, $texto, $usuario); //solo añadimos esto
            break;
    }
} else {
    $digimones = $controladorInv->listarUsu($usuario);
}

if (isset($_REQUEST["error"])) {
    $visibilidad = "";
    $mensaje = "No se ha podido cambiar el digimon, tienes que seleccionar los dos que quieras intercambiar!";
    $clase = "alert alert-danger";
}

?>

<main class="col-md-9 col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Tu Inventario</h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <div id="contenido">
            <div>
                <form action="index.php?tabla=inventarios&accion=inventario&id=<?= $id ?>&evento=filtrar" method="POST">
                    <div class="form-group">
                        <label for="digimon">Buscar Digimon</label><br>
                        <select class="form-select" aria-label="Default select example" id="campo" name="campo">
                            <option value="nombre" selected>Nombre</option>
                            <option value="tipo">Tipo de Digimon</option>
                            <option value="nivel">Nivel del Digimon</option>
                        </select>
                        <select class="form-select" aria-label="Default select example" id="modo" name="modo">
                            <option value="empieza" selected>Empieza Por</option>
                            <option value="acaba">Acaba En</option>
                            <option value="contiene">Contiene</option>
                            <option value="igual">Igual A</option>
                        </select>
                        <input type="text" required class="form-control" id="busqueda" name="busqueda" placeholder="Buscar por Digimon">
                    </div>
                    <button type="submit" class="btn btn-success" name="Filtrar"><i class="fas fa-search"></i> Buscar</button>
                </form>
                <!-- Este formulario es para ver todos los datos    -->
                <form action="index.php?tabla=inventarios&accion=inventario&id=<?= $id ?>&evento=todos" method="POST">
                    <button type="submit" class="btn btn-info" name="Todos"><i class="fas fa-list"></i> Listar</button>
                </form>
            </div>
            <br><br>
            <form action="index.php?tabla=inventarios&accion=guardar&evento=cambiar" method="POST">
                <input type="hidden" id="id_usuario" name="id_usuario" value="<?= $id ?>">
                <button type="submit" class="btn btn-success">Cambiar</button>
                <?php
                //var_dump($digimones);
                foreach ($seleccionados as $key => $digimon) {
                    $digimonesSelec .= "
                        <div class='form-group'>
                            <label>
                                ID: $digimon->id <br>
                                Nombre: $digimon->nombre <br>
                                <img src=assets/img/digimones/$digimon->nombre/$digimon->imagen width='100px'><br>
                                Ataque: $digimon->ataque <br>
                                Defensa: $digimon->defensa <br>
                                Tipo: $digimon->tipo <br>
                                Nivel: $digimon->nivel <br>
                                <input type='radio' name='id_seleccionado' id='$digimon->id' value='$digimon->id'>
                            </label>
                    </div>";
                }
                foreach ($digimones as $digimon) {
                    if (!$digimon->seleccionado) {
                        $digimonesNOSelec .= "
                        <div class='form-group'>
                            <label>
                                ID: $digimon->id <br>
                                Nombre: $digimon->nombre <br>
                                <img src=assets/img/digimones/$digimon->nombre/$digimon->imagen width='100px'><br>
                                Ataque: $digimon->ataque <br>
                                Defensa: $digimon->defensa <br>
                                Tipo: $digimon->tipo <br>
                                Nivel: $digimon->nivel <br>
                                <input type='radio' name='id_noSeleccionado' id='$digimon->id' value='$digimon->id'>
                            </label>
                        </div>";
                    }
                }
                ?>
                <h2 class='h3'>Equipo</h2>
                <div class='form-group, digimones__seleccionados'>
                    <?= $digimonesSelec ?>
                </div>
                <h2 class='h3'>Guardados</h2>
                <div class='form-group'>
                    <?= $digimonesNOSelec ?>
                </div>
            </form>

            <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
            <?php
            //}
            ?>
        </div>
</main>