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
    $mensaje = "Digimon {$digimon->usuario} con id {$id} - {$digimon->name} Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar el {$digimon->usuario} con id {$id} - {$digimon->name} {$id}";
        $clase = "alert alert-danger";
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Digimon <?= $_SESSION["datos"]["usuario"] ?? $digimon->usuario ?> con Id: <?= $id ?> </h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
            $errores = $_SESSION["errores"] ?? [];
        ?>
            <form action="index.php?tabla=user&accion=guardar&evento=modificar" method="POST">
                <input type="hidden" id="id" name="id" value="<?= $digimon->id ?>">
                <div class="form-group">
                    <label for="nombre">Digimon </label>
                    <input type="text" required class="form-control" id="nombre" name="nombre" aria-describedby="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? $digimon->nombre ?>">
                    <input type="hidden" id="nombreOriginal" name="nombreOriginal" value="<?= $digimon->nombre ?>">
                    <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen Normal</label>
                    <input type="imagen" required class="form-control" id="imagen" name="imagen" value="<?= $_SESSION["datos"]["imagen"] ?? $digimon->imagen ?>">
                    <?= isset($errores["imagen"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "imagen") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="imagenV">Imagen Victoria</label>
                    <input type="imagenV" required class="form-control" id="imagenV" name="imagenV" value="<?= $_SESSION["datos"]["imagenV"] ?? $digimon->imagenV ?>">
                    <?= isset($errores["imagenV"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "imagenV") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="imagenD">Imagen Derrota</label>
                    <input type="imagenD" required class="form-control" id="imagenD" name="imagenD" value="<?= $_SESSION["datos"]["imagenD"] ?? $digimon->imagenD ?>">
                    <?= isset($errores["imagenD"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "imagenD") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="ataque">Ataque </label>
                    <input type="text" class="form-control" id="ataque" name="ataque" value="<?= $_SESSION["datos"]["ataque"] ?? $digimon->ataque ?>">
                    <?= isset($errores["ataque"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "ataque") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="email">Defensa </label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION["datos"]["email"] ?? $digimon->email ?>">
                    <input type="hidden" id="emailOriginal" name="emailOriginal" value="<?= $digimon->email ?>">
                    <?= isset($errores["email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "email") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="email">Nivel </label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION["datos"]["email"] ?? $digimon->email ?>">
                    <input type="hidden" id="emailOriginal" name="emailOriginal" value="<?= $digimon->email ?>">
                    <?= isset($errores["email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "email") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="email">Defensa </label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION["datos"]["email"] ?? $digimon->email ?>">
                    <input type="hidden" id="emailOriginal" name="emailOriginal" value="<?= $digimon->email ?>">
                    <?= isset($errores["email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "email") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="email">Tipo </label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION["datos"]["email"] ?? $digimon->email ?>">
                    <input type="hidden" id="emailOriginal" name="emailOriginal" value="<?= $digimon->email ?>">
                    <?= isset($errores["email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "email") . '</div>' : ""; ?>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a class="btn btn-danger" href="index.php?tabla=user&accion=listar">Cancelar</a>
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