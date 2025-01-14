<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administrando el programa</h1>
    </div>
    <div id="contenido">
        <table class="table table-light table-hover">
        <thead class="table-dark">
                <tr>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=ver&id=<?= $id ?>"><i class="fa-regular fa-eye"></i> Listar Usuario</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=ver&id=<?= $id ?>"><i class="fa-solid fa-sitemap"></i> Ver Usuarios</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=jugar&id=<?= $id ?>"><i class="fa-solid fa-hand-fist"></i> Dar de alta a un Digimon</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=evoluvcionar&id=<?= $id ?>"><i class="fa-solid fa-dna"></i> Definir Evoluciones</a></th>
                    <th scope="col"><a class="btn btn-primary" href="index.php?tabla=digimones&accion=editar&id=<?= $id ?>"><i class="fa-solid fa-gear"></i> Borrar Digimones</a></th>
                </tr>
            </thead>
        </table>
    </div>
</main>