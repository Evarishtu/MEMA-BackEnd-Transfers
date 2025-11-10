<?php
require_once __DIR__ . '/../config/database.php';

class Reserva {
    private $conexion;
    private $tabla = "transfer_reservas";

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    public function crearReserva($datos) {
        try {
            $query = "INSERT INTO {$this->tabla} ( 
            localizador, id_hotel, id_tipo_reserva, email_cliente, fecha_reserva, fecha_modificacion, 
            id_destino, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, 
            hora_vuelo_salida, fecha_vuelo_salida, numero_vuelo_salida, 
            hora_recogida, num_viajeros, id_vehiculo) 
            
            VALUES ( :localizador, :id_hotel, :id_tipo_reserva, :email_cliente, :fecha_reserva, 
            :fecha_modificacion, :id_destino, :fecha_entrada, :hora_entrada, 
            :numero_vuelo_entrada, :origen_vuelo_entrada, :hora_vuelo_salida, 
            :fecha_vuelo_salida, :numero_vuelo_salida, :hora_recogida, :num_viajeros, :id_vehiculo )";

            $stmt = $this->conexion->prepare($query);
            return $stmt->execute($datos);
        } catch (PDOException $e) {
            echo("Error al crear reserva: " . $e->getMessage());
            var_dump($datos);
            return false;
        }
    }
}