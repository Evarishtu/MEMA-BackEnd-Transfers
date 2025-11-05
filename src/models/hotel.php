<?php 
require_once __DIR__ . '/../config/database.php';

class Hotel{
    private $conexion;
    private $tabla = "tranfer_hotel";

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();       
    }
    // Obtener todos los hoteles (para el <select>)

    public function listarHoteles(){
        try {
            $query = "SELECT id_hotel, name FROM {$this->tabla} ORDER BY name ASC";
            $stmt = $this->conexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            error_log("Error al listar hoteles: " . $e->getMessage());
            return [];
        }
    }
    public function obtenerIdPorNombre($nombre){
        try{
            $query = "SELECT id_hotel FROM {$this->tabla} WHERE name = :nombre LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel ? $hotel['id_hotel'] : null;
        }catch (PDOException $e){
            error_log("Error al buscar hotel: " . $e->getMessage());
            return null;
        }
    }
    public function obtenerNombrePorId($id){
        try{
            $query = "SELECT name FROM {$this->tabla} WHERE id_hotel = :id LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel ? $hotel['name'] : null;
        }catch (PDOException $e){
            error_log("Error al obtener nombre del hotel: " . $e->getMessage());
            return null;
        }
    }
}