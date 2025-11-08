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
                localizador, id_hotel, id_tipo_reserva, email_cliente, fecha_llegada, hora_llegada,
                numero_vuelo_llegada, origen_vuelo, fecha_salida, hora_salida,
                num_vuelo_salida, hora_recogida, numero_viajeros 
            ) VALUES (
                :localizador, :id_hotel, :id_tipo_reserva, :email_cliente, :fecha_llegada, :hora_llegada,
                :numero_vuelo_llegada, :origen_vuelo, :fecha_salida, :hora_salida,
                :num_vuelo_salida, :hora_recogida, :numero_viajeros, 
            )";

            $stmt = $this->conexion->prepare($query);
            return $stmt->execute($datos);
        } catch (PDOException $e) {
            error_log("Error al crear reserva: " . $e->getMessage());
            var_dump($datos);
            return false;
        }
    }
}