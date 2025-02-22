<?php
require_once "models/digimonesModel.php";
require_once "assets/php/funciones.php";

class DigimonesController
{
    private $model;

    public function __construct()
    {
        $this->model = new DigimonesModel();
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
        $arrayNoNulos = ["nombre", "imagen", "ataque", "defensa", "tipo", "imagenV", "imagenD"];
        $nulos = HayNulos($arrayNoNulos, $arrayDigi);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayDigi["nombre"] != $arrayDigi["nombreOriginal"]) $arrayUnicos[] = "nombre";

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

            move_uploaded_file($nombreTemp, $directorio . urlencode($nombreImagen));

            $nombreTemp = $_FILES["imagenV"]["tmp_name"];
            $nombreImagen = $_FILES["imagenV"]["name"];

            move_uploaded_file($nombreTemp, $directorio . urlencode($nombreImagen));


            $nombreTemp = $_FILES["imagenD"]["tmp_name"];
            $nombreImagen = $_FILES["imagenD"]["name"];

            move_uploaded_file($nombreTemp, $directorio . urlencode($nombreImagen));

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

    public function borrar(int $id): void
    {
        $digimon = $this->ver($id);

        if ($digimon) {
            $directorio = "assets/img/digimones/" . $digimon->nombre;
            $this->eliminarCarpeta($directorio);
        }

        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=buscar&tabla=digimones";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }

    function eliminarCarpeta($carpeta)
    {
        if (is_dir($carpeta)) {
            $archivos = array_diff(scandir($carpeta), array('.', '..'));
            foreach ($archivos as $archivo) {
                $ruta = $carpeta . "/" . $archivo;
                is_dir($ruta) ? $this->eliminarCarpeta($ruta) : unlink($ruta);
            }
            return rmdir($carpeta);
        }
        return false;
    }

    public function editar(string $id, array $arrayDigi): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "nivel", "tipo", "ataque", "defensa"];
        $nulos = HayNulos($arrayNoNulos, $arrayDigi);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayDigi["nombre"] != $arrayDigi["nombreOriginal"]) $arrayUnicos[] = "nombre";

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
            $redireccion = "location:index.php?accion=editar&tabla=digimones&evento=modificar&id={$id}&error=true";
        } else {
            //vuelvo a limpiar por si acaso
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            //este es el nuevo numpieza
            $id = $arrayDigi["id"];
            $redireccion = "location:index.php?accion=editar&tabla=digimones&evento=modificar&id={$id}";

            if ($arrayDigi["nombre"] != $arrayDigi["nombreOriginal"]) {
                $directorioAntiguo = "assets/img/digimones/" . $arrayDigi["nombreOriginal"] . "/";
                $directorioNuevo = "assets/img/digimones/" . $arrayDigi["nombre"] . "/";

                if (file_exists($directorioAntiguo)) {
                    rename($directorioAntiguo, $directorioNuevo);
                }

                // Verificar si hay una imagen personalizada y actualizar la referencia
                $imagenActual = $arrayUser["imagen"] ?? "default.png";
                if ($imagenActual !== "default.png") {
                    $arrayUser["imagen"] = $directorioNuevo . basename($imagenActual);
                }
            }
        }

        header($redireccion);
        exit();
        //vuelvo a la pagina donde estaba
    }

    public function buscar(string $campo = "digimones", string $metodo = "contiene", string $texto = ""): array
    {
        $users = $this->model->search($campo, $metodo, $texto);
        return $users;
    }

    public function darEvolucion(array $arrayDigimones): string
    {
        $idDigimonBase = $arrayDigimones["digimonBase"];
        $idDigimonEvolucion = $arrayDigimones["digimonEvolucion"];

        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        //campos NO VACIOS
        $arrayNoNulos = ["digimonBase", "digimonEvolucion"];
        $nulos = HayNulos($arrayNoNulos, $arrayDigimones);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        if(!$error){
            // Actualizar el campo digi_evu del primer Digimon con el ID del segundo
            $this->model->actualizarEvolucion($idDigimonBase, $idDigimonEvolucion);

            header("location:index.php?tabla=digimones&accion=ver&id={$idDigimonBase}&buscar=true&error=false");
            exit();
        }else{
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayDigimones;
            header("location:index.php?tabla=digimones&accion=ver&id={$idDigimonBase}&buscar=true&error=true");
            exit();
        }
    }
}
