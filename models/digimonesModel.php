<?php
require_once('config/db.php');

class DigimonesModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $digi): ?int //devuelve entero o null
    {
        try {
            $sql = "INSERT INTO digimones(nombre, imagen, imagenV, imagenD, ataque, defensa, nivel, evo_id, tipo)  
            VALUES (:nombre, :imagen, :imagenV, :imagenD, :ataque, :defensa, :nivel, :evo_id, :tipo);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":nombre" => $digi["nombre"],
                ":imagen" => $digi["imagen"]["name"],
                ":imagenV" => $digi["imagenV"]["name"],
                ":imagenD" => $digi["imagenD"]["name"],
                ":ataque" => $digi["ataque"],
                ":defensa" => $digi["defensa"],
                ":nivel" => $digi["nivel"],
                ":evo_id" => $digi["evo_id"],
                ":tipo" => $digi["tipo"],
            ];
            $resultado = $sentencia->execute($arrayDatos);

            /*Pasar en el mismo orden de los ? execute devuelve un booleano. 
            True en caso de que todo vaya bien, falso en caso contrario.*/
            //Así podriamos evaluar
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function read(int $id): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones WHERE id=:id");
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($user == false) ? null : $user;
    }

    public function readAll(): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones;");
        $resultado = $sentencia->execute();
        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $digimones;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM digimones WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado = $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount() <= 0) ? false : true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function actualizarEvolucion($idDigimonBase, $idDigimonEvolucion)
    {
        try {
            $sql = "UPDATE digimones SET evo_id = :digiEvo WHERE id = :idActual";
            $arrayDatos = [
                ":idActual" => $idDigimonBase,
                ":digiEvo" => $idDigimonEvolucion,
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function edit(int $idAntiguo, array $arrayDigimon): bool
    {
        try {
            $sql = "UPDATE digimones SET nombre = :nombre, nivel = :nivel, tipo = :tipo, ";
            $sql .= "ataque = :ataque, defensa = :defensa ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":nombre" => $arrayDigimon["nombre"],
                ":nivel" => $arrayDigimon["nivel"],
                ":tipo" => $arrayDigimon["tipo"],
                ":ataque" => $arrayDigimon["ataque"],
                ":defensa" => $arrayDigimon["defensa"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function search(string $campo, string $modo, string $digimon): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones WHERE $campo LIKE :digimon");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($modo) {
            case 'empieza':
                $arrayDatos = [":digimon" => "$digimon%"];
                break;

            case 'acaba':
                $arrayDatos = [":digimon" => "%$digimon"];
                break;

            case 'contiene':
                $arrayDatos = [":digimon" => "%$digimon%"];
                break;

            default:
                $arrayDatos = [":digimon" => $digimon];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $digimones;
    }

    public function login(string $nombre, string $contrasenya): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones WHERE nombre=:nombre");
        $arrayDatos = [
            ":nombre" => $nombre,
        ];
        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return null;
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($user == false || !password_verify($contrasenya, $user->contrasenya)) ? null : $user;
    }

    public function exists(string $campo, string $valor): bool
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount() <= 0) ? false : true;
    }
}
