<?php
require_once "controllers/usuariosController.php";
require_once "controllers/digimonesController.php";
require_once "controllers/inventariosController.php";

$id = $_REQUEST['id'];
$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new UsuariosController();
$usuario = $controlador->ver($id);
$controladorInv = new InventariosController();
$digimones = $controladorInv->listarUsu($usuario);
$digimonesSelec = "";
$digimonesNOSelec = "";


if (count($digimones) > 0) {
    $mostrarDatos = true;
}

if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}
$id = $_REQUEST['id'];
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Tu Inventario</h1>
    </div>
    <div id="contenido">
        <form action="">
            <button type="submit">Cambiar</button>
            <?php
            //var_dump($digimones);
            if ($mostrarDatos) {
                foreach ($digimones as $digimon) :
                    $id = $digimon->id;
                    if ($digimon->seleccionado) {
                        $digimonesSelec .= "
                    <p class='card-text'>
                        ID: $digimon->id <br>
                        Nombre: $digimon->nombre <br>
                        <img src=assets/img/digimones/$digimon->nombre/$digimon->imagen width='100px'><br>
                        Ataque: $digimon->ataque <br>
                        Defensa: $digimon->defensa <br>
                        Tipo: $digimon->tipo <br>
                        Nivel: $digimon->nivel <br>
                        <input type='radio' name='seleccionado' id='$digimon->id'>
                    </p>
                    ";
                    } else {

                        $digimonesNOSelec .= "
                    <p class='card-text'>
                        ID: $digimon->id <br>
                        Nombre: $digimon->nombre <br>
                        <img src=assets/img/digimones/$digimon->nombre/$digimon->imagen width='100px'><br>
                        Ataque: $digimon->ataque <br>
                        Defensa: $digimon->defensa <br>
                        Tipo: $digimon->tipo <br>
                        Nivel: $digimon->nivel <br>
                        <input type='radio' name='noseleccionado' id='$digimon->id'>
                    </p>
                    ";
                    }
                endforeach;

                echo "<h2 class='h3'>Equipo</h2> $digimonesSelec";
                echo "<h2 class='h3'>Guardados</h2> $digimonesNOSelec";
            ?>
                <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
            <?php
            }
            ?>
        </form>
    </div>
</main>