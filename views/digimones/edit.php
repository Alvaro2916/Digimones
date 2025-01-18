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
        <h1 class="h3">Editar Usuario <?= $_SESSION["datos"]["usuario"] ?? $digimon->usuario ?> con Id: <?= $id ?> </h1>
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
                    <label for="usuario">Usuario </label>
                    <input type="text" required class="form-control" id="usuario" name="usuario" aria-describedby="usuario" value="<?= $_SESSION["datos"]["usuario"] ?? $digimon->usuario ?>">
                    <input type="hidden" id="usuarioOriginal" name="usuarioOriginal" value="<?= $digimon->usuario ?>">
                    <small id="usuario" class="form-text text-muted">Compartir tu usuario lo hace menos seguro.</small>
                    <?= isset($errores["usuario"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "usuario") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" required class="form-control" id="password" name="password" value="<?= $_SESSION["datos"]["password"] ?? $digimon->password ?>">
                    <?= isset($errores["password"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "password") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="name">Nombre </label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION["datos"]["name"] ?? $digimon->name ?>">
                    <?= isset($errores["name"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "name") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email </label>
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