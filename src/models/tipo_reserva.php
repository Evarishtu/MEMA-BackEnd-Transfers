<?php 
require_once __DIR__ . '/../config/database.php';

class TipoReserva {
    private $conexion;
    private $tabla = "transfer_tipo_reserva";

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();
    }
    public function listarTipos(){
        try{
            $query = "SELECT id_tipo_reserva, Descripción FROM {$this->tabla} ORDER BY id_tipo_reserva ASC";
            $stmt = $this->conexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            error_log('Error al listar tipos de reservas: ' . $e->getMessage());
            return [];
        }
    }

    // Obtener un tipo de reserva por ID
    public function get_reservatipoById($id) {
        $query = "SELECT * FROM {$this->tabla} WHERE id_tipo_reserva = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo tipo de reserva
    public function create_reservatipo($descripcion) {
        $query = "INSERT INTO {$this->tabla} (descripcion) VALUES (?)";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$descripcion]);
    }

    // Actualizar un tipo de reserva existente
    public function update_reservatipo($id, $descripcion) {
        $query = "UPDATE {$this->tabla} SET descripcion = ? WHERE id_tipo_reserva = ?";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$descripcion, $id]);
    }

    // Eliminar un tipo de reserva
    public function delete_reservatipo($id) {
        $query = "DELETE FROM {$this->tabla} WHERE id_tipo_reserva = ?";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>