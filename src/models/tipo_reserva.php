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
}
?>