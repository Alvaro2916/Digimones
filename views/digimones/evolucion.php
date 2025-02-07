<?php
require_once "controllers/digimonesController.php";

$controlador = new DigimonesController();
$digimones = $controlador->listar();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Elegir evolución</h1>
    </div>
    <form action="index.php?tabla=digimones&accion=darEvolucion" method="POST">
        <div id="contenido1">
            <label for="digimonBase">Elige un Digimon para evolucionar:</label>
            <select id="digimonBase" name="digimonBase" required>
                <?php foreach ($digimones as $digimon): ?>
                    <option value="<?= $digimon->id ?>">
                        <?= $digimon->nombre ?> (Nivel <?= $digimon->nivel ?>, Tipo <?= ucfirst($digimon->tipo) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="contenido2">
            <label for="digimonEvolucion">Elige el Digimon al que quieres que evolucione:</label>
            <select id="digimonEvolucion" name="digimonEvolucion" required>
                <?php foreach ($digimones as $digimon): ?>
                    <option value="<?= $digimon->id ?>">
                        <?= $digimon->nombre ?> (Nivel <?= $digimon->nivel ?>, Tipo <?= ucfirst($digimon->tipo) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-up"></i> Dar evolución</button>
    </form>
</main>