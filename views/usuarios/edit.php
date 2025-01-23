<?php
require_once "controllers/usuariosController.php";
//recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?tabla=usuarios&accion=buscar&evento=todos');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}
$id = $_REQUEST["id"];
$controlador = new UsuariosController();
$user = $controlador->ver($id);

$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;
if ($user == null) {
    $visibilidad = "visibility";
    $mensaje = "El usuario con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
} else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "visibility";
    $mensaje = "Usuario {$user->nombre} con id {$id} - Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar el {$user->nombre} con id {$id}";
        $clase = "alert alert-danger";
    }
}

const PERMISOS = [
    "Administrador" => "1",
    "Usuario" => "0",
  ];

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Usuario: <?= $_SESSION["datos"]["usuario"] ?? $user->nombre ?> con Id: <?= $id ?> </h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
            $errores = $_SESSION["errores"] ?? [];
        ?>
            <form action="index.php?tabla=usuarios&accion=guardar&evento=modificar&nombre=<?= $user->nombre ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?= $user->id ?>">
                <input type="hidden" id="imagen" name="imagen" value="<?= $user->imagen ?>">
                <div class="form-group">
                    <label for="nombre">Nombre </label>
                    <input type="text" disabled class="form-control" id="nombre" name="nombre" aria-describedby="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? $user->nombre ?>">
                    <input type="hidden" id="nombreOriginal" name="nombreOriginal" value="<?= $user->nombre ?>">
                    <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="contrasenya">Contraseña</label>
                    <input type="password" required class="form-control" id="contrasenya" name="contrasenya" value="<?= $_SESSION["datos"]["contrasenya"] ?? $user->contrasenya ?>">
                    <?= isset($errores["contrasenya"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contrasenya") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="partidas_ganadas">Partida Ganadas </label>
                    <input type="text" class="form-control" id="partidas_ganadas" name="partidas_ganadas" value="<?= $_SESSION["datos"]["partidas_ganadas"] ?? $user->partidas_ganadas ?>">
                    <?= isset($errores["partidas_ganadas"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "partidas_ganadas") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="partidas_perdidas">Partidas Perdidas </label>
                    <input type="text" class="form-control" id="partidas_perdidas" name="partidas_perdidas" value="<?= $_SESSION["datos"]["partidas_perdidas"] ?? $user->partidas_perdidas ?>">
                    <input type="hidden" id="partidas_perdidasOriginal" name="partidas_perdidasOriginal" value="<?= $user->partidas_perdidas ?>">
                    <?= isset($errores["partidas_perdidas"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "partidas_perdidas") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="partidas_totales">Partidas Totales </label>
                    <input type="text" class="form-control" id="partidas_totales" name="partidas_totales" value="<?= $_SESSION["datos"]["partidas_totales"] ?? $user->partidas_totales ?>">
                    <input type="hidden" id="partidas_totalesOriginal" name="partidas_totalesOriginal" value="<?= $user->partidas_totales ?>">
                    <?= isset($errores["partidas_totales"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "partidas_totales") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="permisos">Permisos </label>
                    <select id="permisos" name="permisos" class="form-select" aria-label="Selecciona los permisos del usuario">
                        <option value="">---- Elije El Permiso ----</option>
                        <?php
                        foreach (PERMISOS as $key => $permiso) :
                            $selected = isset($_SESSION["datos"]["permisos"]) && $_SESSION["datos"]["permisos"] == $permiso ? "selected" : "";
                            echo "<option value='{$permiso}' {$selected}>{$key}</option>";
                        endforeach;
                        ?>
                    </select>
                    <?= isset($errores["permisos"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "permisos") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="digi_evu">Puntos para Digievolucionar </label>
                    <input type="text" class="form-control" id="digi_evu" name="digi_evu" value="<?= $_SESSION["datos"]["digi_evu"] ?? $user->digi_evu ?>">
                    <input type="hidden" id="digi_evuOriginal" name="digi_evuOriginal" value="<?= $user->digi_evu ?>">
                    <?= isset($errores["digi_evu"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "digi_evu") . '</div>' : ""; ?>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <?php
                if (isset($_REQUEST["buscar"])) {
                ?>
                    <a class="btn btn-danger" href="index.php?tabla=usuarios&accion=ver&id=<?= $user->id ?>&buscar=true">Cancelar</a>
                <?php
                } else {
                ?>
                    <a class="btn btn-danger" href="index.php?tabla=usuarios&accion=ver&id=<?= $user->id ?>">Cancelar</a>
                <?php
                }
                ?>
            </form>
        <?php
        } else {
        ?>
            <?php
            if (isset($_REQUEST["buscar"])) {
            ?>
                <a class="btn btn-danger" href="index.php?tabla=usuarios&accion=ver&id=<?= $user->id ?>&buscar=true">Cancelar</a>
            <?php
            } else {
            ?>
                <a class="btn btn-danger" href="index.php?tabla=usuarios&accion=ver&id=<?= $user->id ?>">Cancelar</a>
            <?php
            }
            ?>
        <?php
        }
        //Una vez mostrados los errores, los eliminamos
        unset($_SESSION["datos"]);
        unset($_SESSION["errores"]);
        ?>
    </div>
</main>