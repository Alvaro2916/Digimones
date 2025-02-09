<?php
require_once "controllers/usuariosController.php";
require_once "controllers/inventariosController.php";

$id = $_REQUEST['id'];
$digimonesSelec = "";
$digimonesSelecR = "";

$controlador = new UsuariosController();
//Usuario
$usuario = $controlador->ver($id);

//Rival
$rivalEncontrado = false;
while (!$rivalEncontrado) {
    $elegirRival = $controlador->buscar("id", "distinto", $id);
    $rival = $elegirRival[rand(0, count($elegirRival) - 1)];
    if ($rival->nombre != "admin") {
        $rivalEncontrado = true;
    }
}

$controladorInv = new InventariosController();
//Usuario
$seleccionados = $controladorInv->buscarDigimonesSelec($usuario);
//Rival
$seleccionadosRival = $controladorInv->buscarDigimonesSelec($rival, true);

if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}
if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "combatir") {
    $combatir = $controlador->combatir($usuario, $seleccionados, $seleccionadosRival);
    $ganador = count(array_filter($combatir));
}
?>
<main class="px-md-4 asignar-2letra combatirMain">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Vamos a combatir</h1>
    </div>
    <div class="contenidoCombate-Principal">
        <div class="botones-superiores-combatir">
            <a href="index.php" class="btn btn-primary volver"><i class="fa-solid fas fa-chevron-left"></i> Volver a Inicio</a>
            <form action="index.php?tabla=usuarios&accion=combate&id=<?= $id ?>&evento=combatir" method="POST">
                <button type="submit" class="btn btn-success" name="Combatir"><?= isset($_REQUEST["evento"]) ? "Volver a combatir" : "Combatir" ?></button>
            </form>
        </div>
        <div class="contenidoCombate">
            <div class="card tarjetaUsuario" style="width: 18rem;">
                <h5 class="card-title">ID: <?= $usuario->id ?> <br>NOMBRE: <?= $usuario->nombre ?></h5>
                <p class="card-text">
                    ID: <?= $usuario->id ?> <br>
                    Nombre: <?= $usuario->nombre ?><br>
                    <img src=assets/img/usuarios/<?= $usuario->nombre . "/" . $usuario->imagen ?> width="100px" height="100px"><br>
                    Partidas Ganadas: <?= $usuario->partidas_ganadas ?><br>
                    Partidas Perdidas: <?= $usuario->partidas_perdidas ?><br>
                    Partidas Totales: <?= $usuario->partidas_totales ?><br>
                </p>
            </div>
            <div class="cartasDigimones">
                <div class="cartasDigimones-Interior">
                    <?php
                    foreach ($seleccionados as $key => $digimon) {
                        if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "combatir") {
                            $imagen = $combatir[$key] ? $digimon->imagenV : $digimon->imagenD;
                        } else {
                            $imagen = $digimon->imagen;
                        }
                        $digimonesSelec .= "
                            <div class='form-group cartaDigimon'>
                                <label>
                                    ID: $digimon->id <br>
                                    Nombre: $digimon->nombre <br>
                                    <img src='assets/img/digimones/$digimon->nombre/$imagen' width='100px' height='100px'><br>
                                    Ataque: $digimon->ataque <br>
                                    Defensa: $digimon->defensa <br>
                                    Tipo: $digimon->tipo <br>
                                    Nivel: $digimon->nivel <br>
                                </label>
                            </div>";
                    }
                    ?>
                    <h2 class='h3'>Tus Digimones</h2>
                    <?= $digimonesSelec ?>
                </div>
                <?php
                if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "combatir") {
                ?>
                    <div class="centro-combate">
                        <h2>GANADOR: <?= $ganador ? $usuario->nombre : $rival->nombre ?>!!</h2><br>
                        <img src="assets/img/versus.gif" alt="versus">
                    </div>
                    <div class="cartasDigimones-Interior">
                        <?php
                        foreach ($seleccionadosRival as $key => $digimon) {
                            $imagen = $combatir[$key] ? $digimon->imagenD : $digimon->imagenV;
                            $digimonesSelecR .= "
                                <div class='form-group cartaDigimon'>
                                    <label>
                                        ID: $digimon->id <br>
                                        Nombre: $digimon->nombre <br>
                                        <img src='assets/img/digimones/$digimon->nombre/$imagen' width='100px' height='100px'><br>
                                        Ataque: $digimon->ataque <br>
                                        Defensa: $digimon->defensa <br>
                                        Tipo: $digimon->tipo <br>
                                        Nivel: $digimon->nivel <br>
                                    </label>
                                </div>";
                        }
                        ?>
                        <h2 class='h3'>Digimones Rival</h2>
                        <?= $digimonesSelecR ?>
                    </div>
            </div>
            <div class="card tarjetaUsuario" style="width: 18rem;">
                <h5 class="card-title">ID: <?= $rival->id ?> <br>NOMBRE: <?= $rival->nombre ?></h5>
                <p class="card-text">
                    ID: <?= $rival->id ?> <br>
                    Nombre: <?= $rival->nombre ?><br>
                    <img src=assets/img/usuarios/<?= $rival->nombre . "/" . $rival->imagen ?> width="100px" height='100px'><br>
                    Partidas Gandas: <?= $rival->partidas_ganadas ?><br>
                    Partidas Perdidas: <?= $rival->partidas_perdidas ?><br>
                    Partidas Totales: <?= $rival->partidas_totales ?><br>
                </p>
            </div>
        <?php
                }
        ?>
        </div>
    </div>
</main>