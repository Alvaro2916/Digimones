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
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Añadir Digimon</h1>
  </div>
  <div id="contenido">
    <div class="alert alert-danger <?= $visibilidad ?>"><?= $cadena ?></div>
    <form action="index.php?tabla=user&accion=guardar&evento=crear" method="POST">
      <div class="form-group">
        <label for="nombre">Nombre Digimon </label>
        <input type="text" required class="form-control" id="nombre" name="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? "" ?>" aria-describedby="nombre" placeholder="Introduce Digimon">
        <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="imagen">Imagen</label>
        <input type="imagen" required class="form-control" id="imagen" name="imagen" value="<?= $_SESSION["datos"]["imagen"] ?? "" ?>" placeholder="Imagen">
        <?= isset($errores["imagen"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "imagen") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="ataque">Ataque </label>
        <input type="text" class="form-control" id="ataque" name="ataque" placeholder="Introduce el ataque" value="<?= $_SESSION["datos"]["ataque"] ?? "" ?>">
        <?= isset($errores["ataque"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "ataque") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="defensa">Defensa </label>
        <input type="text" class="form-control" id="defensa" name="defensa" value="<?= $_SESSION["datos"]["defensa"] ?? "" ?>" placeholder="Introduce la defensa">
        <?= isset($errores["defensa"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "defensa") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="nivel">Nivel </label>
        <input type="text" class="form-control" id="nivel" name="nivel" value="<?= $_SESSION["datos"]["nivel"] ?? "" ?>" placeholder="Introduce el nivel">
        <?= isset($errores["nivel"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nivel") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="evo_id">Evolución ID </label>
        <input type="text" class="form-control" id="evo_id" name="evo_id" value="<?= $_SESSION["datos"]["evo_id"] ?? "" ?>" placeholder="Introduce ID de evolucion">
        <?= isset($errores["evo_id"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "evo_id") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="tipo">Tipo </label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="<?= $_SESSION["datos"]["tipo"] ?? "" ?>" placeholder="Introduce el tipo">
        <?= isset($errores["tipo"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "tipo") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="tipo">Sube la imagen </label>
        <input type="file" class="form-control" id="tipo" name="tipo" value="<?= $_SESSION["datos"]["tipo"] ?? "" ?>" placeholder="Introduce el tipo">
        <?= isset($errores["tipo"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "tipo") . '</div>' : ""; ?>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a class="btn btn-danger" href="index.php">Cancelar</a>
    </form>

    <?php
    //Una vez mostrados los errores, los eliminamos
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
  </div>
</main>