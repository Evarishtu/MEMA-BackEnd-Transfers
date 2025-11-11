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

    public function obtenerReservaPorLocalizador($localizador) {
        try {
            $query = "SELECT * FROM {$this->tabla} WHERE localizador = :localizador LIMIT 1";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':localizador', $localizador);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener reserva: " . $e->getMessage());
            return false;
        }
    }

    public function listarReservas() {
        try {
            $query = "SELECT * FROM {$this->tabla} ORDER BY fecha_reserva DESC";
            $statement = $this->conexion->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar reservas: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarReserva($id_reserva) {
        try {
            $query = "DELETE FROM {$this->tabla} WHERE id_reserva = :id_reserva";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':id_reserva', $id_reserva);
            return $statement->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar reserva: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarReserva($id_reserva, $datos) {
        try {
            $setPart = [];
            foreach ($datos as $key => $value) {
                $setPart[] = "$key = :$key";
            }
            $setString = implode(", ", $setPart);

            $query = "UPDATE {$this->tabla} SET $setString WHERE id_reserva = :id_reserva";
            $statement = $this->conexion->prepare($query);
            $datos['id_reserva'] = $id_reserva;

            return $statement->execute($datos);
        } catch (PDOException $e) {
            error_log("Error al actualizar reserva: " . $e->getMessage());
            return false;
        }
    }   

    public function contarReservas() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->tabla}";
            $statement = $this->conexion->prepare($query);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error al contar reservas: " . $e->getMessage());
            return 0;
        }
    }

    // RESERVAS DEL VIAJERO ECHAS POR EL MISMO VIAJERO
    public function obtenerReservasPorViajero($email_cliente) {
        try {
            $query = "SELECT * FROM {$this->tabla} WHERE email_cliente = :email_cliente ORDER BY fecha_reserva DESC";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':email_cliente', $email_cliente);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener reservas por viajero: " . $e->getMessage());
            return false;
        }
    }

    // RESERVAS DEL VIAJERO ECHAS POR EL ADMIN
    public function obtenerReservasViajeroAdmin($email_cliente) {
        try {
            $query = "SELECT * FROM {$this->tabla} WHERE email_cliente = :email_cliente ORDER BY fecha_reserva DESC";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':email_cliente', $email_cliente);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener reservas por viajero para admin: " . $e->getMessage());
            return false;
        }
    }

    public function generarLocalizadorUnico() {
        $localizador = bin2hex(random_bytes(5)); // Genera un localizador de 10 caracteres hexadecimales
        // Verificar si el localizador ya existe
        if ($this->obtenerReservaPorLocalizador($localizador)) {
            return $this->generarLocalizadorUnico(); // Si existe, generar uno nuevo
        }
        return $localizador;
    }

}