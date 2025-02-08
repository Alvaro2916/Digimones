<?php
require_once "controllers/digimonesController.php";
//recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?tabla=digimones&accion=listar');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}
$id = $_REQUEST["id"];
$controlador = new DigimonesController();
$digimon = $controlador->ver($id);

const TIPO = ["Planta", "Vacuna", "Elemental", "Virus", "Animal"];
const NIVEL = ["1", "2", "3", "4"];

$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;
if ($digimon == null) {
    $visibilidad = "visibility";
    $mensaje = "El Digimon con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
} else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "visibility";
    $mensaje = "Digimon {$digimon->nombre} con id {$id} - {$digimon->nombre} Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar el Digimon con id {$id} - {$digimon->nombre} {$id}";
        $clase = "alert alert-danger";
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Digimon <?= $_SESSION["datos"]["nombre"] ?? $digimon->nombre ?> con Id: <?= $id ?> </h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
            $errores = $_SESSION["errores"] ?? [];
        ?>
            <form action="index.php?tabla=digimones&accion=guardar&evento=modificar&nombre=<?= $digimon->nombre ?>" method="POST">
                <input type="hidden" id="id" name="id" value="<?= $digimon->id ?>">
                <div class="form-group">
                    <label for="nombre">Nombre </label>
                    <input type="text" required class="form-control" id="nombre" name="nombre" aria-describedby="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? $digimon->nombre ?>">
                    <input type="hidden" id="nombreOriginal" name="nombreOriginal" value="<?= $digimon->nombre ?>">
                    <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="nivel">Nivel </label>
                    <select id="nivel" name="nivel" class="form-select" aria-label="Selecciona el nivel del digimon">
                        <option value="">---- Elije el Nivel del Digimon ----</option>
                        <?php
                        foreach (NIVEL as $nivel) :
                            $selected = $digimon->nivel == $nivel ? "selected" : "";
                            echo "<option value='{$nivel}' $selected >Nivel: {$nivel}</option>";
                        endforeach;
                        ?>
                    </select>
                    <input type="hidden" id="nivelOriginal" name="nivelOriginal" value="<?= $digimon->nivel ?>">
                    <?= isset($errores["nivel"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nivel") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo </label>
                    <select id="tipo" name="tipo" class="form-select" aria-label="Selecciona el tipo del digimon">
                        <option value="">---- Elije El Tipo del Digimon ----</option>
                        <?php
                        foreach (TIPO as $tipo) :
                            $selected = (strtolower($digimon->tipo)) == strtolower($tipo) ? "selected" : "";
                            echo "<option value='{$tipo}' $selected >{$tipo}</option>";
                        endforeach;
                        ?>
                        <input type="hidden" id="tipoOriginal" name="tipoOriginal" value="<?= $digimon->tipo ?>">
                        <?= isset($errores["tipo"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "tipo") . '</div>' : ""; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ataque">Ataque </label>
                    <input type="text" class="form-control" id="ataque" name="ataque" value="<?= $_SESSION["datos"]["ataque"] ?? $digimon->ataque ?>">
                    <?= isset($errores["ataque"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "ataque") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="defensa">Defensa </label>
                    <input type="text" class="form-control" id="defensa" name="defensa" value="<?= $_SESSION["datos"]["defensa"] ?? $digimon->defensa ?>">
                    <input type="hidden" id="defensaOriginal" name="defensaOriginal" value="<?= $digimon->defensa ?>">
                    <?= isset($errores["defensa"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "defensa") . '</div>' : ""; ?>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a class="btn btn-danger" href="index.php?tabla=digimones&accion=buscar">Cancelar</a>
            </form>
        <?php
        } else {
        ?>
            <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
        <?php
        }
        //Una vez mostrados los errores, los eliminamos
        unset($_SESSION["datos"]);
        unset($_SESSION["errores"]);
        ?>
    </div>
</main>