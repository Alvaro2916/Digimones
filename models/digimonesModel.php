<?php
require_once('config/db.php');

class DigimonesModel
{
    private $conexion;

    public function __construct() {
        $this->conexion = db::conexion();
    }

    public function insert(array $user): ?int //devuelve entero o null
    {
        try{
            $sql = "INSERT INTO usuarios(nombre, pfp, partidas_ganadas, partidas_perdidas, partidas_totales, permisos, contrasenya, digi_evu)  
            VALUES (:nombre, :pfp, :partidas_ganadas, :partidas_perdidas, :partidas_totales, :permisos, :contrasenya, :digi_evu);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":nombre"=>$user["nombre"],
                ":pfp"=>$user["pfp"],
                ":partidas_ganadas"=>$user["partidas_ganadas"],
                ":partidas_perdidas"=>$user["partidas_perdidas"],
                ":partidas_totales"=>$user["partidas_totales"],
                ":permisos"=>$user["permisos"],
                ":contrasenya"=>password_verify($user["contrasenya"], PASSWORD_DEFAULT),
                ":digi_evu"=>$user["digi_evu"],
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
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE id=:id");
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
        $sentencia = $this->conexion->prepare("SELECT * FROM digimones;");
        $resultado = $sentencia->execute();
        $digimones = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $digimones;
    }

    public function delete (int $id):bool {
        $sql="DELETE FROM usuarios WHERE id =:id";
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
            $sql="UPDATE usuarios SET nombre = :nombre, email=:email, ";
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

    public function search (string $campo, string $modo, string $usuario):array{
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE $campo LIKE :usuario");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($modo) {
            case 'empieza':
                $arrayDatos=[":usuario"=>"$usuario%" ];
                break;

            case 'acaba':
                $arrayDatos=[":usuario"=>"%$usuario" ];
                break;

            case 'contiene':
                $arrayDatos=[":usuario"=>"%$usuario%" ];
                break;
            
            default:
                $arrayDatos=[":usuario"=>$usuario];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ); 
        return $usuarios;
    }

    public function login(string $nombre,string $contrasenya): ?stdClass {
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
        $arrayDatos = [
            ":nombre" => $nombre,
        ];
        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return null;
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($user == false || !password_verify($contrasenya, $user->contrasenya)) ? null : $user;
    }

    public function exists(string $campo, string $valor):bool{
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount()<=0)?false:true;
    }
}