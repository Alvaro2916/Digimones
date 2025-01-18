<?php
ob_start();
require_once "config/sessionControl.php";
require_once("router/router.php");

require_once("views/layout/head.php");
$vista = router();

if (!file_exists($vista)) "Error, REVISA TUS RUTAS";
else require_once($vista);

require_once("views/layout/footer.php");

$vista = router();
?>
<div class="container-fluid">
    <div class="row">
        <?php
        //Si quitamos esto no se vería el navbar pero no se cuadraría nuestra página. Tenemos que verlo bien


        if (!file_exists($vista)) echo "Error, REVISA TUS RUTAS";
        else require_once($vista);

        $vistasArray = [
            "crear" => "views/usuarios/create.php",
            "guardar" => "views/usuarios/store.php",
            "ver" => "views/usuarios/show.php",
            "listar" => "views/usuarios/list.php",
            "buscar" => "views/usuarios/search.php",
            "borrar" => "views/usuarios/delete.php",
            "editar" => "views/usuarios/edit.php",
            "administrar" => "views/usuarios/administrar.php",
            "crearDigimon" => "views/digimones/create.php",
            "borrarDigimon" => "views/digimones/delete.php",
            "editarDigimon" => "views/digimones/edit.php",
            "buscarDigimon" => "views/digimones/search.php",
            "verDigimon" => "views/digimones/show.php",
        ];

        foreach ($vistasArray as $key => $vistaAlt) {
            if ($vista == $vistaAlt) {
                echo $vistaAlt;
                require_once "views/layout/navbar.php";
                require_once($vista);
            }
        }


        ?>
    </div>
</div>
<?php
require_once("views/layout/footer.php");
?>