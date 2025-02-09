<?php
require_once "controllers/usuariosController.php";
require_once "controllers/digimonesController.php";
require_once "controllers/inventariosController.php";

$id = $_REQUEST['id'];
$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$controlador = new UsuariosController();
$usuario = $controlador->ver($id);
$controladorInv = new InventariosController();
$digimones = $controladorInv->buscarDigimones($usuario);

if (isset($_REQUEST["evento"])) {
    if ($_REQUEST["evento"] == "evolucionar") {
        foreach ($evo as $digimon) {
        }
    }
}

if (isset($_REQUEST["error"])) {
    $visibilidad = "";
    $mensaje = $_SESSION["errores"];
    $clase = "alert alert-danger";
}
?>

<main class="px-md-4 asignar-2letra">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Tus Digimones</h1>
    </div>
    <div>
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <div class="contenidoEvolucion">
            <div class="botones-superiores">
                <a href="index.php?tabla=inventarios&accion=inventario&id=<?= $id ?>" class="btn btn-primary volver"><i class="fa-solid fas fa-chevron-left"></i> Volver a Inicio</a>
            </div>
            <div class="equipo">
                <div class="form-group, digimones__listaEvu">
                    <form action="index.php?tabla=inventarios&accion=guardar&evento=evolucionar" method="POST">
                        <button type="submit" class="btn btn-success evolucionarEnabledEvu"><i class="fa-solid fas fa-dragon"></i> Evolucionar</button>
                        <?php
                        foreach ($digimones as $digimon) {
                        ?>
                            <div class='cartaDigimonEvu'>
                                <label>
                                    ID: <?= $digimon->id ?> <br>
                                    Nombre: <?= $digimon->nombre ?> <br>
                                    <img src="assets/img/digimones/<?= $digimon->nombre . '/' . $digimon->imagen ?>" width='100px'><br>
                                    Ataque: <?= $digimon->ataque ?> <br>
                                    Defensa: <?= $digimon->defensa ?> <br>
                                    Tipo: <?= $digimon->tipo ?> <br>
                                    Nivel: <?= $digimon->nivel ?> <br>
                                    <input type="radio" name="id" id="<?= $digimon->id ?>" value="<?= $digimon->id ?>">
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?= $id ?>">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
</main>
<?php
//Una vez mostrados los errores, los eliminamos
unset($_SESSION["datos"]);
unset($_SESSION["errores"]);
?>