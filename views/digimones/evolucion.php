<?php
require_once "controllers/digimonesController.php";

if (!isset($_REQUEST["id"])) {
    header('location:index.php?tabla=digimones&accion=listar');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}

$id = $_REQUEST["id"];

$controlador = new DigimonesController();

$digimonPrincipal = $controlador->ver($id);

$digimones = $controlador->listar();

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Elegir evolución para el digimon <?= $digimonPrincipal->nombre ?></h1>
    </div>
    <form action="index.php?tabla=digimones&accion=darEvolucion&evento=asignar" method="POST">
        <input type="hidden" name="digimonBase" id="digimonBase" value="<?= $digimonPrincipal->id ?>">
        <?php /*<div id="contenido1">
            <label for="digimonBase">Elige un Digimon para evolucionar:</label>
            <select id="digimonBase" name="digimonBase" required>
                <?php foreach ($digimones as $digimon): ?>
                    <option value="<?= $digimon->id ?>">
                        <?= $digimon->nombre ?> (Nivel <?= $digimon->nivel ?>, Tipo <?= ucfirst($digimon->tipo) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>*/?>
        <div id="contenido2">
            <label for="digimonEvolucion">Elige el Digimon al que quieres que evolucione:</label><br>
            <select id="digimonEvolucion" name="digimonEvolucion" required class="form-select">
                <?php
                foreach ($digimones as $digimon) {
                    if (($digimon->nivel == ($digimonPrincipal->nivel + 1)) && (strtolower($digimon->tipo) == strtolower($digimonPrincipal->tipo))) {
                        $selected = (intval($digimonPrincipal->evo_id) === intval($digimon->id)) ? "selected" : "";
                        echo "<option value='$digimon->id' $selected >";
                        echo "$digimon->nombre  (Nivel $digimon->nivel , Tipo ($digimon->tipo) )";
                        echo "</option>";
                    }
                }
                ?>
            </select>
        </div><br>
        <button type="submit" class="btn btn-success"><i class="fas fa-arrow-up"></i> Dar evolución</button>
        <a class="btn btn-primary" href="index.php?tabla=digimones&accion=ver&id=<?= $id ?>&buscar=true">Volver al Digimon</a>
    </form>

</main>