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
    public function listarTodas($filtros = []){
        $query = "SELECT r.*,
                    t.Descripción AS tipo_descripcion,
                    h.nombre AS hotel_nombre,
                    v.Descripción AS vehiculo_descripcion
                FROM {$this->tabla} r
                LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                LEFT JOIN tranfer_hotel h ON r.id_hotel = h.id_hotel
                LEFT JOIN transfer_vehiculo v ON r.id_vehiculo = v.id_vehiculo
                WHERE 1=1";
        $parametros = [];
          if(!empty($filtros['desde'])){
            $query .= " AND r.fecha_reserva >= :desde";
            $parametros[':desde'] = $filtros['desde'];
        }
        if(!empty($filtros['hasta'])){
            $query .= " AND r.fecha_reserva <= :hasta";
            $parametros[':hasta'] = $filtros['hasta'];
        }
        if(!empty($filtros['tipo'])){
            $query .= " AND r.id_tipo_reserva = :tipo";
            $parametros[':tipo'] = $filtros['tipo'];
        }
        if(!empty($filtros['hotel'])){
            $query .= " AND r.id_hotel = :hotel";
            $parametros[':hotel'] = $filtros['hotel'];
        }
        if(!empty($filtros['q'])){
            $query .=" AND (r.localizador LIKE :q OR r.email_cliente LIKE :q)";
            $parametros[':q'] = '%' . $filtros['q'] . '%';
        }

        $query .= " ORDER BY r.fecha_reserva DESC";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute($parametros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id){
          $query = "SELECT r.*, 
                        t.Descripción AS tipo_descripcion,
                        h.nombre AS hotel_nombre,
                        v.Descripción AS vehiculo_descripcion
                    FROM {$this->tabla} r
                    LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                    LEFT JOIN tranfer_hotel h ON r.id_hotel = h.id_hotel
                    LEFT JOIN transfer_vehiculo v ON r.id_vehiculo = v.id_vehiculo
                    WHERE r.id_reserva = :id";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function actualizarReserva($datos){
        $query = "UPDATE {$this->tabla} SET
                    id_hotel = :id_hotel,
                    id_tipo_reserva = :id_tipo_reserva,
                    email_cliente = :email_cliente,
                    fecha_modificacion = NOW(),
                    fecha_entrada = :fecha_entrada,
                    hora_entrada = :hora_entrada,
                    numero_vuelo_entrada = :numero_vuelo_entrada,
                    origen_vuelo_entrada = :origen_vuelo_entrada,
                    fecha_vuelo_salida = :fecha_vuelo_salida,
                    hora_vuelo_salida = :hora_vuelo_salida,
                    numero_vuelo_salida = :numero_vuelo_salida,
                    hora_recogida = :hora_recogida,
                    num_viajeros = :num_viajeros,
                    id_vehiculo = :id_vehiculo
                WHERE id_reserva = :id_reserva";

        $stmt = $this->conexion->prepare($query);
        return $stmt->execute($datos); 
    }
    public function eliminarReserva($id){
        $query = "DELETE FROM {$this->tabla} WHERE id_reserva = :id";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function listarEventosCalendario(){
        $query = "SELECT 
                    r.id_reserva,
                    r.localizador,
                    r.fecha_entrada,
                    r.hora_entrada,
                    r.fecha_vuelo_salida,
                    r.hora_vuelo_salida,
                    r.num_viajeros,
                    r.email_cliente,
                    t.Descripción AS tipo_descripcion,
                    h.nombre AS hotel_nombre
                FROM {$this->tabla} r
                LEFT JOIN transfer_tipo_reserva t ON r.id_tipo_reserva = t.id_tipo_reserva
                LEFT JOIN tranfer_hotel h ON r.id_hotel = h.id_hotel
                ORDER BY r.fecha_entrada ASC, r.fecha_vuelo_salida ASC";

        $stmt = $this->conexion->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}