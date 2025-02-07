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
    if ($_REQUEST["evento"]=="evolucionar") {
        foreach ($evo as $digimon) {
            
        }
    }
}

if (isset($_REQUEST["error"])) {
    $visibilidad = "";
    $mensaje = "No se ha podido cambiar el digimon, tienes que seleccionar los dos que quieras intercambiar!";
    $clase = "alert alert-danger";
}
?>

<main class="col-md-9 col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Tus Digimones</h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <div id="contenido">
            <form action="index.php?tabla=inventarios&accion=guardar&evento=evolucionar" method="POST">
                <button type="submit" class="btn btn-success">Evolucionar</button>
                <?php
                //var_dump($digimones);
                foreach ($digimones as $digimon) {
                ?>
                    <div class='form-group'>
                        <label>
                            ID: <?=$digimon->id?> <br>
                            Nombre: <?=$digimon->nombre?> <br>
                            <img src="assets/img/digimones/<?= $digimon->nombre.'/'.$digimon->imagen?>" width='100px'><br>
                            Ataque: <?=$digimon->ataque?> <br>
                            Defensa: <?=$digimon->defensa?> <br>
                            Tipo: <?=$digimon->tipo?> <br>
                            Nivel: <?=$digimon->nivel?> <br>
                            <input type='radio' name='id_Evo' id='<?=$digimon->id?>' value='<?=$digimon->id?>'>
                        </label>
                    </div>
                <?php
                }
                ?>
            </form>

            <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
        </div>
</main>