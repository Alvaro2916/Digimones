<?php
require_once "models/inventariosModel.php";
require_once "models/usuariosModel.php";
require_once "assets/php/funciones.php";
require_once "digimonesController.php";
require_once "usuariosController.php";

class InventariosController
{
    private $model;

    public $modelUsu;

    private $digimones;

    public function __construct()
    {
        $this->model = new InventariosModel();

        $this->modelUsu = new UsuariosModel();

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

    public function evolucionarDigimon(int $id, int $id_usuario)
    {
        $controladorDigi = new DigimonesController();
        $controladorUsu = new UsuariosController();

        //Errores
        $error = false;
        $errores = "";

        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        //campos NO VACIOS
        if ($id == 0) {
            $error = true;
            $errores = "Tienes que seleccionar el digimon que quieres evolucionar!";
        } else {
            //Digimon que tenemos
            $digimon = $controladorDigi->ver($id);

            //Digimon que no tiene evolucion
            if ($digimon->evo_id == 0) {
                $error = true;
                $errores = "Este digimon no tiene evolucion";
            }
        }

        if ($error) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $id;

            header("location:index.php?tabla=inventarios&accion=digievolucionar&id={$id_usuario}&error=true");
            exit();
        } else {

            //Usuario
            $usuario = $controladorUsu->ver($id_usuario);

            //Digimon al que evoluciona
            $idDigiEvolucionar = $digimon->evo_id;

            $digisInv = $this->buscar("usuario_id", "igual", $id_usuario, $usuario);
            foreach ($digisInv as $digiInv) {
                if ($digiInv->digimon_id == $idDigiEvolucionar) {
                    $_SESSION["errores"] = "Este digimon ya está evolucionado!";
                    $_SESSION["datos"] = $id;

                    header("location:index.php?tabla=inventarios&accion=digievolucionar&id={$id_usuario}&error=true");
                    exit();
                }
                if ($digiInv->digimon_id == $id) {
                    $inv = $digiInv->seleccionado;
                }
            }

            $digiEvolucion = [
                "usuario_id" => $id_usuario,
                "digimon_id" => $idDigiEvolucionar,
                "seleccionado" => $inv,
            ];

            $insertado = $this->model->insert($digiEvolucion);
            $usuario->digi_evu -= 1;
            $this->modelUsu->edit($usuario->id, get_object_vars($usuario));
            if ($insertado) {
                $this->model->delete($id, $id_usuario);
            }

            header("location:index.php?tabla=inventarios&accion=inventario&id={$id_usuario}");
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
                    $digimonNuevo = [
                        "usuario_id" => $usuario->id,
                        "digimon_id" => $digimonesN1[$i]->id,
                        "seleccionado" => 0,
                    ];
                    $encontrado = true;
                }
            }
            $this->model->insert($digimonNuevo);
        }
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
