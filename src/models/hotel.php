<?php 
require_once __DIR__ . '/../config/database.php';

class Hotel{
    private $conexion;
    private $tabla = "transfer_hotel";

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();       
    }
    public function registrarHotel($nombre_hotel, $id_zona, 
    $comision, $usuario, $password){
        try{
            if($this->existeHotel($nombre_hotel) || $this->existeUsuario($usuario)){
                echo "<p>El hotel o el usuario ya están registrados.</p>";
                return false;
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO {$this->tabla}
            (id_zona, name, comision, usuario, password)
            VALUES(:id_zona, :name, :comision, :usuario, :password)";

            $stmt = $this->conexion->prepare($query);
            $id_zona = !empty($id_zona) ? $id_zona : null;
            $comision = !empty($comision) ? $comision : null;

            $stmt->bindParam(':id_zona', $id_zona);
            $stmt->bindParam(':name', $nombre_hotel);
            $stmt->bindParam(':Comison', $comision);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $hash);

            return $stmt->execute();
        }catch (PDOException $e){
            error_log("Error al registrar hotel: ". $e->getMessage());
            return false;
        }
    }
    private function existeHotel($nombre_hotel){
        try{
            $query = "SELECT COUNT(*) FROM {$this->tabla} WHERE name = :name";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':name', $nombre_hotel);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }catch (PDOException $e){
            error_log("Error al verificar hotel: " . $e->getMessage());
            return false;
        }
    }
    private function existeUsuario($usuario){
        try{
            $query = "SELECT COUNT(*) FROM {$this->tabla} WHERE usuario = :usuario";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }catch (PDOException $e){
            error_log("Error al verificar usuario de hotel: " . $e->getMessage());
            return false;
        }
    }
    
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
    
    public function obtenerPorUsuario($usuario) {
    try {
        $query = "SELECT * FROM {$this->tabla} WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener hotel por usuario: " . $e->getMessage());
        return false;
    }
}
}