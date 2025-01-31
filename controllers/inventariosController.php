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

    public function crear(array $arrayDigi): void
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO
        $arrayDigi["tipo"] = strtolower($arrayDigi["tipo"]);

        if (!is_valid_tipo($arrayDigi["tipo"])) {
            $error = true;
            $errores["tipo"][] = "El tipo tiene un formato incorrecto";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "imagen", "ataque", "defensa", "evo_id", "tipo", "imagenV", "imagenD"];
        $nulos = HayNulos($arrayNoNulos, $arrayDigi);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["nombre"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayDigi[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayDigi[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }
        $id = null;
        if (!$error) $id = $this->model->insert($arrayDigi);

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayDigi;
            header("location:index.php?accion=crear&tabla=digimones&error=true&id={$id}");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);

            $directorio = "assets/img/digimones/" . $_REQUEST["nombre"] . "/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreTemp = $_FILES["imagen"]["tmp_name"];
            $nombreImagen = $_FILES["imagen"]["name"];

            move_uploaded_file($nombreTemp, $directorio . $nombreImagen);

            $nombreTemp = $_FILES["imagenV"]["tmp_name"];
            $nombreImagen = $_FILES["imagenV"]["name"];

            move_uploaded_file($nombreTemp, $directorio . $nombreImagen);


            $nombreTemp = $_FILES["imagenD"]["tmp_name"];
            $nombreImagen = $_FILES["imagenD"]["name"];

            move_uploaded_file($nombreTemp, $directorio . $nombreImagen);



            header("location:index.php?accion=ver&tabla=digimones&id=" . $id);
            exit();
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

    public function borrar(int $id): void
    {
        $digimon = $this->ver($id);
        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=buscar&tabla=digimones";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }

    public function editar(string $id, array $arrayDigi): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        // ERRORES DE TIPO
        if (!is_valid_email($arrayDigi["email"])) {
            $error = true;
            $errores["email"][] = "El email tiene un formato incorrecto";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["email", "password", "usuario"];
        $nulos = HayNulos($arrayNoNulos, $arrayDigi);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayDigi["email"] != $arrayDigi["emailOriginal"]) $arrayUnicos[] = "email";
        if ($arrayDigi["usuario"] != $arrayDigi["usuarioOriginal"]) $arrayUnicos[] = "usuario";

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayDigi[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$CampoUnico}  {$arrayDigi[$CampoUnico]}  ya existe";
                $error = true;
            }
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayDigi);

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayDigi;
            $redireccion = "location:index.php?accion=editar&tabla=user&evento=modificar&id={$id}&error=true";
        } else {
            //vuelvo a limpiar por si acaso
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            //este es el nuevo numpieza
            $id = $arrayDigi["id"];
            $redireccion = "location:index.php?accion=editar&tabla=user&evento=modificar&id={$id}";
        }
        header($redireccion);
        exit();
        //vuelvo a la pagina donde estaba
    }

    public function buscar(string $campo = "nombre", string $metodo = "contiene", string $texto = "", stdClass $user): array
    {
        $users = $this->model->search($campo, $metodo, $texto, $user);
        return $users;
    }
}
