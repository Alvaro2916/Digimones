<main class=" px-md-4 asignar-2letra">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">INICIO </h1>
  </div>
  <div class="inicio">
    <table>
      <thead>
        <tr class="inicioTabla">
          <th scope="col"><a class="btn btn-principal" href="index.php?tabla=inventarios&accion=inventario&id=<?= $_SESSION["usuario"]->id ?>"><i class="fa-regular fas fa-eye"></i> Ver mis Digimons (Inventario)</a></th>
          <th scope="col"><a class="btn btn-principal" href="index.php?tabla=usuarios&accion=combate&id=<?= $_SESSION["usuario"]->id ?>"><i class="fa-solid fas fa-dice-d20"></i> Jugar Partida</a></th>
        </tr>
      </thead>
    </table>
  </div>
</main>