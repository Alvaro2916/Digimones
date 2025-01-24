<?php
require_once('config/db.php');

class InventariosModel
{
    private $conexion;

    public function __construct() {
        $this->conexion = db::conexion();
    }

    public function insert(array $digi): ?int //devuelve entero o null
    {
        try{
            $sql = "INSERT INTO digimones_inv(usuario_id, digimon_id)  
            VALUES (:usuario_id, :digimon_id);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":usuario_id"=>$digi["usuario_id"],
                ":digimon_id"=>$digi["digimon_id"],
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

    public function read(int $id): ?stdClass {
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

    public function readAll(): array {
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones_inv;");
        $resultado = $sentencia->execute();
        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $digimones;
    }

    public function delete (int $id):bool {
        $sql="DELETE FROM digimones_inv WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado= $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount ()<=0)?false:true;
        }  catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function edit (int $idAntiguo, array $arrayUsuario):bool{
        try {
            $sql="UPDATE digimones_inv SET nombre = :nombre, email=:email, ";
            $sql.= "usuario = :usuario, contrasenya= :contrasenya ";
            $sql.= " WHERE id = :id;";
            $arrayDatos=[
                    ":id"=>$idAntiguo,
                    ":usuario"=>$arrayUsuario["usuario"],
                    ":contrasenya"=>password_verify($arrayUsuario["contrasenya"], PASSWORD_DEFAULT),
                    ":nombre"=>$arrayUsuario["nombre"],
                    ":email"=>$arrayUsuario["email"],
                    ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos); 
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function search (string $campo, string $modo, string $digimon):array{
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones WHERE $campo LIKE :digimon");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($modo) {
            case 'empieza':
                $arrayDatos=[":digimon"=>"$digimon%" ];
                break;

            case 'acaba':
                $arrayDatos=[":digimon"=>"%$digimon" ];
                break;

            case 'contiene':
                $arrayDatos=[":digimon"=>"%$digimon%" ];
                break;
            
            default:
                $arrayDatos=[":digimon"=>$digimon];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ); 
        return $digimones;
    }

    public function readAllbyUser(stdClass $user ): array{ 

        $sql= "select digimones_inv.*,  digimones.*, "; 

        $sql.="from digimon_inv "; 

        $sql.="left join digimones on (digimon_inv.digimon_id=digimones.id) ";  

        $sql.= " WHERE digimon_inv.digimon_id=:digimones_id;"; 

        $arrayDatos = [":digimones_id" => $user->id ]; 

        $sentencia = $this->conexion->prepare($sql); 

        $sentencia->execute($arrayDatos); 

        $proyectos = $sentencia->fetchAll(PDO::FETCH_OBJ); 

        return $proyectos; 

    } 
}