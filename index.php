<?php
ob_start();
require_once "config/sessionControl.php";
require_once ("router/router.php");

require_once ("views/layout/head.php");
$vista=router ();

if (!file_exists($vista)) "Error, REVISA TUS RUTAS";
else require_once ($vista);

require_once ("views/layout/footer.php");

$vista = router();
?>
<div class="container-fluid">
    <div class="row">
        <?php
        //Si quitamos esto no se vería el navbar pero no se cuadraría nuestra página. Tenemos que verlo bien
        require_once "views/layout/navbar.php";

        if (!file_exists($vista)) echo "Error, REVISA TUS RUTAS";
        else require_once($vista);
        ?>
        uwu
    </div>
</div>
<?php
require_once("views/layout/footer.php");
?>