<?php
require_once "controllers/usuariosController.php";
require_once "controllers/inventariosController.php";

if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}

$id = $_REQUEST['id'];
$digimonesSelec = "";
$digimonesSelecR = "";

$controlador = new UsuariosController();
//Usuario
$usuario = $controlador->ver($id);
//Rival
$elegirRival = $controlador->buscar("id", "distinto", $id);
$rival = $elegirRival[rand(0, count($elegirRival) - 1)];

$controladorInv = new InventariosController();
//Usuario
$seleccionados = $controladorInv->buscarDigimonesSelec($usuario);
//Rival
$seleccionadosRival = $controladorInv->buscarDigimonesSelec($rival);

$combatir = $controlador->combatir($seleccionados, $seleccionadosRival);

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Vamos a combatir</h1>
    </div>
    <div id="contenido">
        <div class="card" style="width: 18rem;">
            <div>
                <h5 class="card-title">ID: <?= $usuario->id ?> <br>NOMBRE: <?= $usuario->nombre ?></h5>
                <p class="card-text">
                    ID: <?= $usuario->id ?> <br>
                    Nombre: <?= $usuario->nombre ?><br>
                    <img src=assets/img/usuario/<?= $usuario->nombre . "/" . $usuario->imagen ?> width="100px"><br>
                    Partidas Gandas: <?= $usuario->partidas_ganadas ?><br>
                    Partidas Perdidas: <?= $usuario->partidas_perdidas ?><br>
                    Partidas Totales: <?= $usuario->partidas_totales ?><br>
                </p>
            </div>
        </div>
    </div>
    <?php
    foreach ($seleccionados as $key => $digimon) {
        $digimonesSelec .= "
                <div class='form-group'>
                    <label>
                        ID: $digimon->id <br>
                        Nombre: $digimon->nombre <br>
                        <img src=assets/img/digimones/$digimon->nombre/$digimon->imagen width='100px'><br>
                        Ataque: $digimon->ataque <br>
                        Defensa: $digimon->defensa <br>
                        Tipo: $digimon->tipo <br>
                        Nivel: $digimon->nivel <br>
                    </label>
                </div>";
    }
    ?>
    <h2 class='h3'>Tus Digimones</h2>
    <div class='form-group, digimones__seleccionados'>
        <?= $digimonesSelec ?>
    </div>

    <div>
        <a href="index.php" class="btn btn-primary">Combatir</a>
    </div>
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Tu rival es <?= $rival->nombre ?></h1>
    </div>
    <div id="contenido">
        <div class="card" style="width: 18rem;">
            <div>
                <h5 class="card-title">ID: <?= $rival->id ?> <br>NOMBRE: <?= $rival->nombre ?></h5>
                <p class="card-text">
                    ID: <?= $rival->id ?> <br>
                    Nombre: <?= $rival->nombre ?><br>
                    <img src=assets/img/usuario/<?= $rival->nombre . "/" . $rival->imagen ?> width="100px"><br>
                    Partidas Gandas: <?= $rival->partidas_ganadas ?><br>
                    Partidas Perdidas: <?= $rival->partidas_perdidas ?><br>
                    Partidas Totales: <?= $rival->partidas_totales ?><br>
                </p>
            </div>
        </div>
    </div>
    <?php
    foreach ($seleccionadosRival as $key => $digimon) {
        $digimonesSelecR .= "
                <div class='form-group'>
                    <label>
                        ID: $digimon->id <br>
                        Nombre: $digimon->nombre <br>
                        <img src=assets/img/digimones/$digimon->nombre/$digimon->imagen width='100px'><br>
                        Ataque: $digimon->ataque <br>
                        Defensa: $digimon->defensa <br>
                        Tipo: $digimon->tipo <br>
                        Nivel: $digimon->nivel <br>
                    </label>
                </div>";
    }
    ?>
    <h2 class='h3'>Digimones Rival</h2>
    <div class='form-group, digimones__seleccionados'>
        <?= $digimonesSelecR ?>
    </div>
</main>