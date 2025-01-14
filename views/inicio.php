<?php

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inventario</h1>
  </div>
  <div id="contenido">
    <?php
    /*$variables = [
        "ana", 
        "luis",
        "maria",
        "admin",
      ];

      foreach ($variables as $key => $value) {
        echo password_hash($value, PASSWORD_DEFAULT) ."<br>";
      }*/
    ?>
    <table class="table table-light table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=ver&id=<?= $id ?>"><i class="fa-regular fa-eye"></i> Ver mis Digimons</a></th>
          <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=ver&id=<?= $id ?>"><i class="fa-solid fa-sitemap"></i> Organizar Equipo</a></th>
          <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=jugar&id=<?= $id ?>"><i class="fa-solid fa-hand-fist"></i> Jugar Partida</a></th>
          <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=evoluvcionar&id=<?= $id ?>"><i class="fa-solid fa-dna"></i> Digievolucionar</a></th>
          <th scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=administrar"><i class="fa-solid fa-gear"></i> Administrar</a></th>
        </tr>
      </thead>
    </table>
  </div>
</main>