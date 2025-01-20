<?php
require_once "models/usuariosModel.php";
require_once "assets/php/funciones.php";

class UsuariosController
{
    private $model;

    public function __construct()
    {
        $this->model = new UsuariosModel();
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
                move_uploaded_file($nombreTemp, $directorio . $nombreImagen);
            } else {              
                $imagenPorDefecto = "assets/img/usuarios/default.png";
                $destino = $directorio . "default.png";
                copy($imagenPorDefecto, $destino);
            }

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
        $redireccion = "location:index.php?accion=listar&tabla=user&evento=borrar&id={$id}&usuario={$usuario->usuario}&nombre={$usuario->name}";

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
        if (!is_valid_email($arrayUser["email"])) {
            $error = true;
            $errores["email"][] = "El email tiene un formato incorrecto";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["email", "password", "usuario"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayUser["email"] != $arrayUser["emailOriginal"]) $arrayUnicos[] = "email";
        if ($arrayUser["usuario"] != $arrayUser["usuarioOriginal"]) $arrayUnicos[] = "usuario";

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$CampoUnico}  {$arrayUser[$CampoUnico]}  ya existe";
                $error = true;
            }
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayUser);

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayUser;
            $redireccion = "location:index.php?accion=editar&tabla=user&evento=modificar&id={$id}&error=true";
        } else {
            //vuelvo a limpiar por si acaso
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            //este es el nuevo numpieza
            $id = $arrayUser["id"];
            $redireccion = "location:index.php?accion=editar&tabla=user&evento=modificar&id={$id}";
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
}
