<?php
require_once "models/inventariosModel.php";
require_once "assets/php/funciones.php";
require_once "digimonesController.php";

class InventariosController
{
    private $model;

    private $digimones;

    public function __construct()
    {
        $this->model = new InventariosModel();

        $this->digimones = new DigimonesController();
    }

    public function buscarDigimonesSelec($usuario, bool $rival = false)
    {
        $digisUsu = $this->listarUsu($usuario);
        $digisS = [];

        foreach ($digisUsu as $digi) {
            if ($digi->seleccionado) {
                $digisS[] = $digi;
            }
        }

        return $digisS;
    }

    public function buscarDigimones($usuario)
    {
        $digisUsu = $this->listarUsu($usuario);
        $digisS = [];

        foreach ($digisUsu as $digi) {
            $digisS[] = $digi;
        }

        return $digisS;
    }

    public function cambiarDigimones($digimonesC)
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        //campos NO VACIOS
        $arrayNoNulos = ["id_seleccionado", "id_noSeleccionado", "id_usuario"];
        $nulos = HayNulos($arrayNoNulos, $digimonesC);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "Tienes que seleccionar los dos digimones que quieras intercambiar!";
            }
        }

        if ($error) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $digimonesC;

            header("location:index.php?tabla=inventarios&accion=inventario&id={$digimonesC["id_usuario"]}&error=true");
            exit();
        } else {
            $this->model->cambiarDigimones($digimonesC);

            header("location:index.php?tabla=inventarios&accion=inventario&id={$digimonesC["id_usuario"]}");
            exit();
        }
    }

    private function EstaEnArray(stdClass $digi, array $nuevoDigis): bool
    {
        foreach ($nuevoDigis as $key => $d) {
            if ($d["digimon_id"] == $digi->id) {
                return true;
            }
        }
        return false;
    }


    public function addRandomDigimon(stdClass $usuario)
    {
        $digimonesN1 = $this->digimones->buscar("nivel", "igual", "1");
        $totalDigiN1 = count($digimonesN1);
        $digimonesUsuario = array_map(function ($item) {
            return (array) $item;
        }, $this->listarUsu($usuario));
        $encontrado = false;

        if (!(count($digimonesUsuario) >= $totalDigiN1)) {
            while (!$encontrado) {
                $i = random_int(0, $totalDigiN1 - 1);
                if (!$this->EstaEnArray($digimonesN1[$i], $digimonesUsuario)) {
                    //$nuevoDigis[]=$digimonesN1[$i];            
                    $digimonNuevo = [
                        "usuario_id" => $usuario->id,
                        "digimon_id" => $digimonesN1[$i]->id,
                        "seleccionado" => 0,
                    ];
                    $encontrado = true;
                }
            }
        }
        $this->model->insert($digimonNuevo);
    }

    public function addPrimerosDigimones($userId)
    {
        //$digimonesN1= $this->digimones->listar();
        $digimonesN1 = $this->digimones->buscar("nivel", "igual", "1");
        $totalDigiN1 = count($digimonesN1);
        $nuevoDigis = [];

        while (count($nuevoDigis) < 3) {
            $i = random_int(0, $totalDigiN1 - 1);
            if (!$this->EstaEnArray($digimonesN1[$i], $nuevoDigis)) {
                //$nuevoDigis[]=$digimonesN1[$i];            
                $nuevoDigis[] = [
                    "usuario_id" => $userId,
                    "digimon_id" => $digimonesN1[$i]->id,
                    "seleccionado" => 1,
                ];
            }
        }

        foreach ($nuevoDigis as $key => $dC) {
            $this->model->insert($dC);
        }
    }

    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

    public function listar()
    {
        $digimones = $this->model->readAll();
        return $digimones;
    }

    public function listarUsu($usuario)
    {
        $digimones = $this->model->readAllbyUser($usuario);
        return $digimones;
    }

    public function buscar(string $campo = "nombre", string $metodo = "contiene", string $texto = "", stdClass $user): array
    {
        $users = $this->model->search($campo, $metodo, $texto, $user);
        return $users;
    }
}
