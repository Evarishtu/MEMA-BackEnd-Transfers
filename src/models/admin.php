<?php 
require_once __DIR__ . '/../config/database.php';

class Admin{
    private $conexion;
    private $tabla = "transfer_admin";

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();
    }
    // Registrar nuevo administrador
    public function registrarAdmin($nombre, $email, $password, $rol = 'administrador'){
        try{
            $query = "INSERT INTO {$this->tabla} (nombre, email, password, rol)
                VALUES (:nombre, :email, :password, :rol)";
            $statement = $this->conexion->prepare($query);

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':password', $hash);
            $statement->bindParam(':rol', $rol);

            return $statement->execute();
        }catch (PDOException $e){
            echo "Error al registrar administrador: " . $e->getMessage();
            return false;
        }
    }
    // Autenticar administrador
    public function autenticarAdmin($email, $password){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE email = :email";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $admin = $statement->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])){
                return $admin;
            }else{
               return false; 
            }
            
        }catch(PDOException $e){
            echo "Error al autenticar administrador: " . $e->getMessage();
            return false;
        }
    }
    // MOstrar todos los administradores
    public function mostrarTodosAdmins(){
        try{
            $query = "SELECT id_admin, nombre, email, rol FROM {$this->tabla}";
            $statement = $this->conexion->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo "Error al obtener administradores: " . $e->getMessage();
            return [];
        }
    }
}

?>