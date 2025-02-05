<?php
require_once "models/usuariosModel.php";
require_once "assets/php/funciones.php";
require_once "inventariosController.php";

class UsuariosController
{
    private $model;

    private $inventario;

    public function __construct()
    {
        $this->model = new UsuariosModel();
        $this->inventario = new InventariosController();
    }

    public function crear(array $arrayUser): void
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "contrasenya"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["nombre"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayUser[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }
        $id = null;
        if (!$error) $id = $this->model->insert($arrayUser);

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayUser;
            header("location:index.php?accion=crear&tabla=usuarios&error=true&id={$id}");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);

            $directorio = "assets/img/usuarios/" . $_REQUEST["nombre"] . "/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreTemp = $_FILES["imagen"]["tmp_name"];
            $nombreImagen = $_FILES["imagen"]["name"];


            if (!empty($_FILES["imagen"]["tmp_name"])) {
                move_uploaded_file($nombreTemp, $directorio . urlencode($nombreImagen));
            } else {
                $imagenPorDefecto = "assets/img/usuarios/default.png";
                $destino = $directorio . "default.png";
                copy($imagenPorDefecto, $destino);
            }

            $this->inventario->addPrimerosDigimones($id);

            header("location:index.php?accion=ver&tabla=usuarios&id=" . $id);
            exit();
        }
    }

    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

    public function listar()
    {
        $users = $this->model->readAll();
        return $users;
    }

    public function borrar(int $id): void
    {
        $usuario = $this->ver($id);
        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=buscar&tabla=usuarios";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }

    public function editar(string $id, array $arrayUser): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "contrasenya"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayUser["nombre"] != $arrayUser["nombreOriginal"]) $arrayUnicos[] = "nombre";

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayUser[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayUser);

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayUser;
            $redireccion = "location:index.php?accion=editar&tabla=usuarios&evento=modificar&id={$id}&error=true";
        } else {
            //vuelvo a limpiar por si acaso
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            //este es el nuevo numpieza
            $id = $arrayUser["id"];
            $redireccion = "location:index.php?accion=editar&tabla=usuarios&evento=modificar&id={$id}";
        }
        header($redireccion);
        exit();
        //vuelvo a la pagina donde estaba
    }

    public function buscar(string $campo = "nombre", string $metodo = "contiene", string $texto = ""): array
    {
        $users = $this->model->search($campo, $metodo, $texto);
        return $users;
    }

    public function combatir(stdClass $usuario, stdClass $rival, array $digimonesUsu, array $digimonesRiv): array
    {
        $ganador = [];
        for ($i = 0; $i < 3; $i++) {
            $calcUsu=$this->calculo($digimonesUsu[$i], $digimonesRiv[$i]);
            $calcRiv=$this->calculo($digimonesRiv[$i], $digimonesUsu[$i]);

            if ($calcUsu > $calcRiv) {
                $ganador []= 1;
            }else {
                $ganador []= 0;
            }
        }
        if(array_sum($ganador) >= 2){
            $usuario->partidas_ganadas+=1;
            $usuario->partidas_totales+=1;
            $this->model->edit($usuario->id, get_object_vars($usuario));
        }else {
            $usuario->partidas_perdidas+=1;
            $usuario->partidas_totales+=1;
            $this->model->edit($usuario->id, get_object_vars($usuario));
        }
        return $ganador;
    }

    public function calculo(stdClass $digimonPrincipal, stdClass $digimonRival): int
    {
        switch ($digimonPrincipal->tipo) {
            case "vacuna":
                switch ($digimonRival->tipo) {
                    case "virus":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 10 + rand(0, 50);
                    case "animal":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 5 + rand(0, 50);
                    case "planta":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 5 + rand(0, 50);
                    case "elemental":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 10 + rand(0, 50);
                    default:
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 0 + rand(0, 50);
                }

            case "virus":
                switch ($digimonRival->tipo) {
                    case "animal":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 10 + rand(0, 50);
                    case "planta":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 5 + rand(0, 50);
                    case "elemental":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 5 + rand(0, 50);
                    case "vacuna":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 10 + rand(0, 50);
                    default:
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 0 + rand(0, 50);
                }

            case "animal":
                switch ($digimonRival->tipo) {
                    case "planta":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 10 + rand(0, 50);
                    case "elemental":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 5 + rand(0, 50);
                    case "vacuna":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 5 + rand(0, 50);
                    case "virus":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 10 + rand(0, 50);
                    default:
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 0 + rand(0, 50);
                }

            case "planta":
                switch ($digimonRival->tipo) {
                    case "elemental":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 10 + rand(0, 50);
                    case "vacuna":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 5 + rand(0, 50);
                    case "virus":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 5 + rand(0, 50);
                    case "animal":
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa - 10 + rand(0, 50);
                    default:
                        return $digimonPrincipal->ataque + $digimonPrincipal->defensa + 0 + rand(0, 50);
                }

            case "elemental":
                switch ($digimonRival->tipo) {
                    case "vacuna":
                        return $digimonPrincipal["ataque"] + $digimonPrincipal->defensa + 10 + rand(0, 50);
                    case "virus":
                        return $digimonPrincipal["ataque"] + $digimonPrincipal->defensa + 5 + rand(0, 50);
                    case "animal":
                        return $digimonPrincipal["ataque"] + $digimonPrincipal->defensa - 5 + rand(0, 50);
                    case "planta":
                        return $digimonPrincipal["ataque"] + $digimonPrincipal->defensa - 10 + rand(0, 50);
                    default:
                        return $digimonPrincipal["ataque"] + $digimonPrincipal->defensa + 0 + rand(0, 50);
                }

            default:
                return 0;
        }
    }
}
