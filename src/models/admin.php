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
    public function registrarAdmin($nombre, $email, $password){
        try{
            $query = "INSERT INTO {$this->tabla} (nombre, email, password)
                VALUES (:nombre, :email, :password)";
            $statement = $this->conexion->prepare($query);

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':password', $hash);

            return $statement->execute();
        }catch (PDOException $e){
            error_log("Error al registrar administrador: " . $e->getMessage());
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
            }
            return false; 
            
            
        }catch(PDOException $e){
            error_log("Error al autenticar administrador: " . $e->getMessage());
            return false;
        }
    }
    // MOstrar todos los administradores
    public function mostrarTodosAdmins(){
        try{
            $query = "SELECT id_admin, nombre, email FROM {$this->tabla}";
            $statement = $this->conexion->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo "Error al obtener administradores: " . $e->getMessage();
            return [];
        }
    }

    // Obtener información de un administrador por ID
    public function obtenerAdminPorId($id_admin){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE id_admin = :id_admin";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':id_admin', $id_admin);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo "Error al obtener administrador: " . $e->getMessage();
            return null;
        }
    }

    public function actualizarAdmin($id_admin, $datos){
        try{
            $query = "UPDATE {$this->tabla} SET nombre = :nombre, email = :email WHERE id_admin = :id_admin";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':nombre', $datos['nombre']);
            $statement->bindParam(':email', $datos['email']);
            $statement->bindParam(':id_admin', $id_admin);

            return $statement->execute();
        }catch (PDOException $e){
            echo "Error al actualizar administrador: " . $e->getMessage();
            return false;
        }
    }

    public function InfoAdminPorEmail($email){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE email = :email";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo "Error al obtener administrador por email: " . $e->getMessage();
            return null;
        }
    }

    public function actualizarAdminCompleto($id_admin, $datos){
        try {
            $query = "UPDATE {$this->tabla}
                      SET nombre = :nombre,
                          email  = :email,
                          password = :password
                      WHERE id_admin = :id_admin";

            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':nombre', $datos['nombre']);
            $stmt->bindParam(':email', $datos['email']);
            $stmt->bindParam(':password', $datos['password']);
            $stmt->bindParam(':id_admin', $id_admin);

            return $stmt->execute();
        } catch(PDOException $e){
            error_log("Error al actualizar administrador: " . $e->getMessage());
            return false;
        }
    }
}

?>