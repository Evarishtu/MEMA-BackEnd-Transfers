<?php 
require_once __DIR__ . '/../models/usuario.php';
require_once __DIR__ . '/../models/hotel.php';

class RegistroController{
    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $rol = $_POST['rol'] ?? '';
            if(empty($rol)){
                header('Location: /?url=registro/registrar');
                exit;
            }
            switch($rol){
                case 'usuario_cliente':
                case 'usuario_admin':
                    include __DIR__ . '/../views/registro/registro_cliente_admin.php';
                    break;
                case 'hotel':
                    include __DIR__ . '/../views/registro/registro_hotel.php';
                    break;
                
                default:
                    header('Location: /?url=registro/registrar');
                    exit;
                }
        }else{
            include __DIR__ . '/../views/registro/registro.php';
        }
    }
    public function guardarUsuario(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=registro/registrar');
            exit;
        }

        $rol = $_POST['rol'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido1 = $_POST['apellido1'] ?? '';
        $apellido2 = $_POST['apellido2'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $codigoPostal = $_POST['codigoPostal'] ?? '';
        $ciudad = $_POST['ciudad'] ?? '';
        $pais = $_POST['pais'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if(
        empty($nombre) || empty($apellido1) || empty($direccion) || 
        empty($codigoPostal) || empty ($ciudad) || empty ($pais) ||
        empty($email) || empty ($password)
        ){
        echo "<p>Todos los campos son obligatorios.</p>";
        echo "<a href='/?url=registro/registrar'>Volver</a>";
        exit;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<p>El formato del correo electrónico no es válido.</p>";
            echo "<a href='/?url=registro/registrar'>Volver</a>";
        }
        $usuarioModel = new Usuario();
        $resultado = $usuarioModel->registrarUsuario(
            $nombre, $apellido1, $apellido2, $direccion, $codigoPostal,
            $ciudad, $pais, $email, $password, $rol
        );
        if ($resultado){
            header('Location: /?url=login/login');
            exit;
        }else{
            echo "<p>Error al registrar el usuario.</p>";
            echo "<a href='/?url=registro/registrar'>Volver</a>";
        }
    }
    public function guardarHotel(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=registro/registrar');
            exit;
        }
        $nombre_hotel = $_POST['nombre_hotel'] ?? '';
        $id_zona = $_POST['id_zona'] ?? null;
        $comision = $_POST['comision'] ?? null;
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';
        if (empty($nombre_hotel) || empty($usuario) || empty($password)){
            echo "<p>Todos los campos obligatorios deben completarse.</p>";
            echo "<a href='/?url=registro/registrar'>Volver</a>";
            exit;
        }
        $hotelModel = new Hotel();
        $resultado = $hotelModel ->registrarHotel(
            $nombre_hotel, $id_zona, $comision, $usuario, $password
        );
        if($resultado){
            header('Location: /?url=login/login');
            exit;
        }else{
            echo "<p>Error al registrar el hotel.</p>";
            echo "<a href='/?url=registro/registrar'>Volver</a>";
        }
    }
}          
?>
