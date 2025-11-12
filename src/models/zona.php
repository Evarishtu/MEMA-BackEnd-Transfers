<?php
require_once __DIR__ . '/../config/database.php';

class Zona {
    private $conexion;
    private $tabla = "transfer_zona";

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();
    }

    // Mostrar todas las zonas
    public function get_zonasAll(){
        $query = "SELECT * FROM {$this->tabla} ORDER BY id_zona ASC";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    // Obtener una zona por ID
    public function get_zonasById($id) {
        $query = "SELECT * FROM {$this->tabla} WHERE id_zona = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva zona
    public function create_zona($descripcion) {
        $query = "INSERT INTO {$this->tabla} (descripcion) VALUES (?)";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$descripcion]);
    }

    // Actualizar una zona existente
    public function update_zona($id, $descripcion) {
        $query = "UPDATE {$this->tabla} SET descripcion = ? WHERE id_zona = ?";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$descripcion, $id]);
    }

    // Eliminar una zona
    public function delete_zona($id) {
        $query = "DELETE FROM {$this->tabla} WHERE id_zona = ?";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$id]);
    }
}

?>