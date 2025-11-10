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
            $query = "SELECT id_vehiculo, Descripción FROM {$this->tabla} ORDER BY id_vehiculo ASC";
            $stmt = $this->conexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            error_log("Error al listar vehículos: " . $e->getMessage());
            return [];
        }
    }
    public function obtenerDescripcionPorId($id){
        try{
            $query = "SELECT Descripción FROM {$this->tabla} WHERE id_vehiculo = :id LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
            return $vehiculo ? $vehiculo['Descripción'] : null;
        }catch (PDOException $e){
            error_log("Error al obtener descripción del vehículo: " . $e->getMessage());
            return null;
        }
    }
}
?>