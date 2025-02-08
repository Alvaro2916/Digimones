<?php
require_once('config/db.php');

class InventariosModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function cambiarDigimones($digimonesC)
    {
        try {
            $sql = "UPDATE digimones_inv SET seleccionado = CASE 
            WHEN digimon_id = :id_seleccionado THEN 0
            WHEN digimon_id = :id_noSeleccionado THEN 1
            ELSE seleccionado
            END  ";

            $sql .= " WHERE digimon_id IN (:id_seleccionado, :id_noSeleccionado) AND usuario_id = :id_usuario; ";
            $arrayDatos = [
                ":id_seleccionado" => $digimonesC["id_seleccionado"],
                ":id_noSeleccionado" => $digimonesC["id_noSeleccionado"],
                ":id_usuario" => $digimonesC["id_usuario"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function insert(array $digi): ?int //devuelve entero o null
    {
        try {
            $sql = "INSERT INTO digimones_inv(usuario_id, digimon_id, seleccionado)  
            VALUES (:usuario_id, :digimon_id, :seleccionado);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":usuario_id" => $digi["usuario_id"],
                ":digimon_id" => $digi["digimon_id"],
                ":seleccionado" => $digi["seleccionado"],
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
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones_inv WHERE id=:id");
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
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones_inv;");
        $resultado = $sentencia->execute();
        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $digimones;
    }

    public function search(string $campo, string $modo, string $digimon, stdClass $user): array
    {
        try {
            $sentencia = $this->conexion->prepare("SELECT * FROM digimones_inv 
            LEFT JOIN digimones on (digimones_inv.digimon_id=digimones.id) 
            WHERE $campo LIKE :digimon AND digimones_inv.usuario_id=:usuario_id");
            //ojo el si ponemos % siempre en comillas dobles "
            switch ($modo) {
                case 'empieza':
                    $digimon = "$digimon%";
                    break;
                case 'acaba':
                    $digimon = "%$digimon";
                    break;
                case 'contiene':
                    $digimon = "%$digimon%";
                    break;
            }
    
            $arrayDatos = [
                ":digimon" => $digimon,
                ":usuario_id" => $user->id,
            ];

            $resultado = $sentencia->execute($arrayDatos);
            if (!$resultado) return [];
            $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $digimones;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function readAllbyUser(stdClass $user): array
    {

        $sql = "select digimones_inv.*,  digimones.* ";

        $sql .= "from digimones_inv ";

        $sql .= "left join digimones on (digimones_inv.digimon_id=digimones.id) ";

        $sql .= " WHERE digimones_inv.usuario_id=:usuario_id;";

        $arrayDatos = [":usuario_id" => $user->id];

        $sentencia = $this->conexion->prepare($sql);

        $sentencia->execute($arrayDatos);

        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return $digimones;
    }
}
