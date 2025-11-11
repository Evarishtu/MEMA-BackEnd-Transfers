<?php
require_once __DIR__ . '/../config/database.php';

class Viajero {
    private $conexion;
    private $tabla = "transfer_viajeros";

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    // ====================================
    // Registrar nuevo viajero
    // ====================================
    public function registrarViajero($nombre, $apellido1, $apellido2, $email, $password, $direccion, $codigoPostal, $pais, $ciudad) {
        try {
            if ($this->existeEmail($email)){
                return "email_duplicado";
            }
            $query = "INSERT INTO {$this->tabla} 
                      (nombre, apellido1, apellido2, email, password, direccion, codigoPostal, pais, ciudad)
                      VALUES 
                      (:nombre, :apellido1, :apellido2, :email, :password, :direccion, :codigoPostal, :pais, :ciudad)";
            $statement = $this->conexion->prepare($query);

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':apellido1', $apellido1);
            $statement->bindParam(':apellido2', $apellido2);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':password', $hash);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':codigoPostal', $codigoPostal);
            $statement->bindParam(':pais', $pais);
            $statement->bindParam(':ciudad', $ciudad);

            return $statement->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar viajero: " . $e->getMessage());
            return false;
        }
    }

    // ====================================
    // Autenticar viajero
    // ====================================
    public function autenticarViajero($email, $password) {
        try {
            $query = "SELECT * FROM {$this->tabla} WHERE email = :email LIMIT 1";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $viajero = $statement->fetch(PDO::FETCH_ASSOC);

            if ($viajero && password_verify($password, $viajero['password'])) {
                return $viajero;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error al autenticar viajero: " . $e->getMessage());
            return false;
        }
    }

    // ====================================
    // Mostrar todos los viajeros
    // ====================================
    public function mostrarTodosViajeros() {
        try {
            $query = "SELECT id_viajero, nombre_cliente, email, ciudad, pais FROM {$this->tabla}";
            $statement = $this->conexion->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener viajeros: " . $e->getMessage());
            return [];
        }
    }

    public function existeEmail($email){
        try{
            $query = "SELECT COUNT(*) FROM {$this->tabla} WHERE email = :email";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }catch (PDOException $e){
            error_log("Error al verificar email del viajero" . $e->getMessage());
            return false;
        }
    }

    // ====================================
    // Mostrar informacion personal del viajero
    // ====================================

    public function obtenerViajeroPorEmail($email) {
        try {
            $query = "SELECT id_viajero, nombre, apellido1, apellido2, email, direccion, codigoPostal, pais, ciudad 
                        FROM {$this->tabla} WHERE email = :email LIMIT 1";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener viajero: " . $e->getMessage());
            return false;
        }
    }

    // ====================================
    // Actualizar informacion personal del viajero
    // ====================================

    public function actualizarViajero($id_viajero, $datos) {
        try {
            $campos = [];
            foreach ($datos as $key => $value) {
                $campos[] = "$key = :$key";
            }
            $setString = implode(", ", $campos);

            $query = "UPDATE {$this->tabla} SET $setString WHERE id_viajero = :id_viajero";
            $stmt = $this->conexion->prepare($query);

            $datos['id_viajero'] = $id_viajero;
            return $stmt->execute($datos);
        } catch (PDOException $e) {
            error_log("Error al actualizar viajero: " . $e->getMessage());
            return false;
        }
    }


    // ====================================
    // Mostrar todos los viajeros
    // ====================================

}
?>