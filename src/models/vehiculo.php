<?php 
require_once __DIR__ . '/../config/database.php';

class Vehiculo{
    private $conexion;
    private $tabla = "transfer_vehiculo";

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();
    }


    public function listarVehiculos(){
        try{
            $query = "SELECT id_vehiculo, descripcion FROM {$this->tabla} ORDER BY id_vehiculo ASC";
            $stmt = $this->conexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            error_log("Error al listar vehículos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerDescripcionPorId($id){
        try{
            $query = "SELECT descripcion FROM {$this->tabla} WHERE id_vehiculo = :id LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
            return $vehiculo ? $vehiculo['descripcion'] : null;
        }catch (PDOException $e){
            error_log("Error al obtener descripción del vehículo: " . $e->getMessage());
            return null;
        }
    }

    public function crearVehiculo($descripcion, $email_conductor = null, $password_conductor = null) {
        try {
            $query = "INSERT INTO {$this->tabla} (descripcion, email_conductor, password) 
                        VALUES (:descripcion, :email_conductor, :password_conductor)";
            $stmt = $this->conexion->prepare($query);
            
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':email_conductor', $email_conductor);
            $stmt->bindParam(':password_conductor', $password_conductor);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear vehículo: " . $e->getMessage());
            return false;
        }
    }


    public function actualizarVehiculo($id, $descripcion){
        try{
            $query = "UPDATE {$this->tabla} SET descripcion = :descripcion WHERE id_vehiculo = :id";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }catch (PDOException $e){
            error_log("Error al actualizar vehículo: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarVehiculo($id){
        try{
            $query = "DELETE FROM {$this->tabla} WHERE id_vehiculo = :id";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }catch (PDOException $e){
            error_log("Error al eliminar vehículo: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerVehiculoPorId($id){
        try{
            $query = "SELECT id_vehiculo, descripcion FROM {$this->tabla} WHERE id_vehiculo = :id LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            error_log("Error al obtener vehículo por ID: " . $e->getMessage());
            return null;
        }
    }

    public function contarVehiculos(){
        try{
            $query = "SELECT COUNT(*) as total FROM {$this->tabla}";
            $stmt = $this->conexion->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int)$result['total'] : 0;
        }catch (PDOException $e){
            error_log("Error al contar vehículos: " . $e->getMessage());
            return 0;
        }
    }
}
?>