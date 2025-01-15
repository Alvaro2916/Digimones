<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Juego Digimons </title>
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/css/dashboard.css" rel="stylesheet">
  <link href="assets/css/404.css" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" <?= $_SESSION["usuario"]->permisos==1?"style='background-color: darkgreen;'":"style='background-color: black;'"?>>
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="">Digimons Game</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3 disabled" href=""> Usuario Conectado: <?= $_SESSION["usuario"]->nombre ?></a>
      </div>
    </div>
    <div class="navbar-nav">
    <?php
      if($_SESSION["usuario"]->permisos==1) {
    ?>
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="index.php?tabla=usuarios&accion=administrar&id=<?= $_SESSION["usuario"]->nombre ?>">Administrar</a>
      </div>
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="logout.php">Sign out</a>
      </div>
    </div>
    <?php } else { ?>
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="logout.php">Sign out</a>
      </div>
    </div>
    <?php } ?>
  </header>