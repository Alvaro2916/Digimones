<?php
require_once "assets/php/funciones.php";
$cadenaErrores = "";
$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";
if (isset($_REQUEST["error"])) {
  $errores = ($_SESSION["errores"]) ?? [];
  $datos = ($_SESSION["datos"]) ?? [];
  $cadena = "Atención Se han producido Errores";
  $visibilidad = "visible";
}

const PERMISOS = [
  "Administrador" => "1",
  "Usuario" => "0",
];
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Añadir usuario</h1>
  </div>
  <div id="contenido">
    <div class="alert alert-danger <?= $visibilidad ?>"><?= $cadena ?></div>
    <form action="index.php?tabla=usuarios&accion=guardar&evento=crear" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="partidas_ganadas" name="partidas_ganadas" value="0">
      <input type="hidden" id="partidas_perdidas" name="partidas_perdidas" value="0">
      <input type="hidden" id="partidas_totales" name="partidas_totales" value="0">
      <input type="hidden" id="digi_evu" name="digi_evu" value="0">
      <div class="form-group">
        <label for="nombre">Nombre </label>
        <input type="text" required class="form-control" id="nombre" name="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? "" ?>" aria-describedby="nombre" placeholder="Introduce tu nombre">
        <small id="usuario" class="form-text text-muted">Compartir tu usuario lo hace menos seguro.</small>
        <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="contrasenya">Contraseña</label>
        <input type="password" required class="form-control" id="contrasenya" name="contrasenya" value="<?= $_SESSION["datos"]["contrasenya"] ?? "" ?>" placeholder="Contraseña">
        <?= isset($errores["contrasenya"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contrasenya") . '</div>' : ""; ?>
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
        <label for="imagen">Sube tu foto de perfil (opcional) </label>
        <input type="file" class="form-control" id="imagen" name="imagen" value="<?= $_SESSION["datos"]["imagen"] ?? "" ?>" placeholder="Introduce la Imagen (opcional)">
        <?= isset($errores["imagen"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "imagen") . '</div>' : ""; ?>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fas fa-check"></i> Guardar</button>
      <a href="index.php?tabla=usuarios&accion=administrar" class="btn btn-danger"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
    </form>

    <?php
    //Una vez mostrados los errores, los eliminamos
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
  </div>
</main>