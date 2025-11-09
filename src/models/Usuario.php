<?php 
require_once __DIR__ . '/../config/database.php';

class Usuario{
    private $conexion;
    private $tabla = 'transfer_viajero';

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    public function registrarUsuario(
    $nombre, $apellido1, $apellido2, $direccion,
    $codigoPostal, $ciudad, $pais, $email, $password, $tipo_usuario)
    {
        try{
            if($this->existeEmail($email)){
                echo "<p>El correo electrónico ya está registrado.</p>";
                return false;
            }
            $tipos_validos = ['usuario_cliente', 'usuario_admin'];
            if(!in_array($tipo_usuario, $tipos_validos)){
                $tipo_usuario = 'usuario_cliente';
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO {$this->tabla}
            (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad,
            pais, email, password, tipo_usuario )
            VALUES
            (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, 
            :ciudad, :pais, :email, :password, :tipo_usuario)";

            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido1', $apellido1);
            $stmt->bindParam(':apellido2', $apellido2);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':codigoPostal', $codigoPostal);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            return $stmt->execute();
            
        }catch (PDOException $e){
            error_log("Error al registrar usuario: ". $e->getMessage());
            return false;
        }
    }
    private function existeEmail($email){
        try{
            $query = "SELECT COUNT(*) FROM {$this->tabla} WHERE email = :email";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }catch (PDOException $e){
            error_log("Error al verificar email: " . $e->getMessage());
            return false;
        }
    }
    public function obtenerPorEmail($email){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE email = :email LIMIT 1";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            error_log("Error al obtener usuario: " . $e->getMessage());
            return false;
        }
    }
}
?>