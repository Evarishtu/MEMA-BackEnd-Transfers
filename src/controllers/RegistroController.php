<?php 
require_once __DIR__ . '/../models/admin.php';
require_once __DIR__ . '/../models/viajero.php';
require_once __DIR__ . '/../models/hotel.php';

class RegistroController{
    //==================================
    // Registro
    //==================================
    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Primer paso: usuario eligió el rol
            if (isset($_POST['rol']) && (
            ($_POST['rol'] !== 'hotel' && empty($_POST['email'])) ||
            ($_POST['rol'] === 'hotel' && empty($_POST['usuario']))
            )) {
                $rol = $_POST['rol'];

                switch($rol){
                    case 'administrador':
                        include __DIR__ . '/../views/auth/registro_administrador.php';
                        return;
                    case 'viajero':
                        include __DIR__ . '/../views/auth/registro_viajero.php';
                        return;
                    case 'hotel':
                        include __DIR__ . '/../views/auth/registro_hotel.php';
                        return;
                    default:
                        header('Location: /?url=registro/registrar');
                        exit;
                }
            }
           // Segundo paso: procesar el formulario completo
           $rol = $_POST['rol'] ?? '';

           switch($rol){
            case 'administrador':
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $nombre = $_POST['nombre'] ?? '';

                if(empty($email) || empty($password) || empty($nombre)){                   
                    header('Location: /?url=registro/registrar');
                    exit;
                }
                $adminModel = new Admin();
                $resultado = $adminModel->registrarAdmin($nombre, $email, $password);

                if($resultado){                   
                    header('Location: /?url=login/login');
                    exit;
                }else{
                    header('Location: /?url=registro/registrar');
                    exit;
                }
            break;
            case 'viajero':
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $nombre = $_POST['nombre'] ?? '';
                $apellido1 = $_POST['apellido1'] ?? '';
                $apellido2 = $_POST['apellido2'] ?? '';
                $direccion = $_POST['direccion'] ?? '';
                $codigoPostal = $_POST['codigoPostal'] ?? '';
                $pais = $_POST['pais'] ?? '';
                $ciudad = $_POST['ciudad'] ?? '';
                 if (
                    empty($email) || empty($password) || empty($nombre) ||
                    empty($apellido1) || empty($apellido2) || empty($direccion) ||
                    empty($codigoPostal) || empty($pais) || empty($ciudad)
                ) {
                    header('Location: /?url=registro/registrar');
                    exit;
                }
                $viajeroModel = new Viajero();
                $resultado = $viajeroModel->registrarViajero(
                    $nombre, $apellido1, $apellido2, $email, $password,
                    $direccion, $codigoPostal, $pais, $ciudad
                );
                if($resultado){
                    // var_dump ($resultado);
                    header('Location: /?url=login/login');
                    exit;
                }else{
                    echo "<p>Error al registrar viajero</p>";
                    echo "<a href='/?url=registro/registrar'>Volver</a>";
                    exit;
                }
            break;
            case 'hotel':
                $nombre_hotel = $_POST['nombre'] ?? '';
                $id_zona = $_POST['id_zona'] ?? null;
                $comision = $_POST['comision'] ?? null;
                $usuario = $_POST['usuario'] ?? '';
                $password = $_POST['password'] ?? '';

                if(empty($nombre_hotel) || empty($usuario) || empty($password)){
                    echo "<p>Nombre, usuario y contraseña son obligatorios.</p>";
                    echo "<a href='/?url=registro/registrar'>Volver</a>";
                    exit;
                }
            $hotelModel = new Hotel();
            $resultado = $hotelModel->registrarHotel($nombre_hotel, $id_zona, $comision, $usuario, $password);
            
            if($resultado){
                header('Location: /?url=login/login');
                exit;
            }else{
                echo "<p>Error al registrar hotel</p>";
                echo "<a href='/?url=registro/registrar'>Volver</a>";
                exit;
            }
            break;
            default:
                header('Location: /?url=registro/registrar');
                exit;
           }
        }else{
            include __DIR__ . '/../views/auth/registro.php';
        }
    }
}           
?>
