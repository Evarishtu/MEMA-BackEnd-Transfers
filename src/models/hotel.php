<?php 
require_once __DIR__ . '/../config/database.php';

class Hotel {
    private $conexion;
    private $tabla = "tranfer_hotel"; 

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();       
    }

    // ============================================================
    // Registrar un nuevo hotel
    // ============================================================
    public function registrarHotel($nombre_hotel, $id_zona, $comision, $usuario, $password){
        try {
            
            if ($this->existeHotel($nombre_hotel) || $this->existeUsuario($usuario)) {
                echo "<p>El hotel o el usuario ya están registrados.</p>";
                return false;
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO {$this->tabla} (id_zona, nombre, comision, usuario, password)
                      VALUES (:id_zona, :nombre, :comision, :usuario, :password)";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':id_zona', $id_zona);
            $stmt->bindParam(':nombre', $nombre_hotel);
            $stmt->bindParam(':comision', $comision);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $hash);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo("Error al registrar hotel: " . $e->getMessage());
            return false;
        }
    }

    private function existeHotel($nombre_hotel){
        try {
            $query = "SELECT COUNT(*) FROM {$this->tabla} WHERE nombre = :nombre";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre_hotel);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar hotel: " . $e->getMessage());
            return false;
        }
    }

    private function existeUsuario($usuario){
        try {
            $query = "SELECT COUNT(*) FROM {$this->tabla} WHERE usuario = :usuario";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar usuario: " . $e->getMessage());
            return false;
        }
    }

    // ============================================================
    // Obtener todos los hoteles (para listas / selects)
    // ============================================================
    public function listarHoteles(){
        try {
            $query = "SELECT id_hotel, nombre FROM {$this->tabla} ORDER BY nombre ASC";
            $stmt = $this->conexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar hoteles: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerIdPorNombre($nombre){
        try {
            $query = "SELECT id_hotel FROM {$this->tabla} WHERE nombre = :nombre LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel ? $hotel['id_hotel'] : null;
        } catch (PDOException $e) {
            error_log("Error al buscar hotel: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerNombrePorId($id){
        try {
            $query = "SELECT nombre FROM {$this->tabla} WHERE id_hotel = :id LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel ? $hotel['nombre'] : null;
        } catch (PDOException $e) {
            error_log("Error al obtener nombre del hotel: " . $e->getMessage());
            return null;
        }
    }

    public function listarHotelesConZona() {
        try {
            $query = "SELECT 
                            h.id_hotel, h.nombre     AS nombre_hotel,
                            z.id_zona, z.descripcion AS nombre_zona
                        FROM tranfer_hotel h
                        LEFT JOIN transfer_zona z 
                            ON h.id_zona = z.id_zona
                        ORDER BY h.id_hotel ASC";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al listar hoteles con zona: ' . $e->getMessage());
            return [];
        }
    }

    public function eliminarHotel($id_hotel) {
        try {
            $query = "DELETE FROM tranfer_hotel WHERE id_hotel = :id_hotel";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id_hotel', $id_hotel);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al eliminar hotel: ' . $e->getMessage());
            return false;
        }
    }


    public function crearHotel($nombre, $id_zona) {
        try {
            $query = "INSERT INTO tranfer_hotel (nombre, id_zona) VALUES (:nombre, :id_zona)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':id_zona', $id_zona);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al crear hotel: ' . $e->getMessage());
            return false;
        }
    }

    public function obtenerZonaIdPorHotelId($id_hotel) {
        try {
            $query = "SELECT id_zona FROM tranfer_hotel WHERE id_hotel = :id_hotel LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':id_hotel', $id_hotel);
            $stmt->execute();
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $hotel ? $hotel['id_zona'] : null;
        } catch (PDOException $e) {
            error_log("Error al obtener zona por ID de hotel: " . $e->getMessage());
            return null;
        }
    }
}
?>