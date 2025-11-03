<?php 
require_once __DIR__ . '/../models/admin.php';
require_once __DIR__ . '/../models/viajero.php';

class RegistroController{
    //==================================
    // Registro
    //==================================
    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Primer paso: usuario eligió el rol
            if(isset($_POST['rol']) && empty($_POST['email'])){
                $rol = $_POST['rol'];

                switch($rol){
                    case 'administrador':
                        include __DIR__ . '/../views/auth/registro_administrador.php';
                        break;
                    case 'viajero':
                        include __DIR__ . '/../views/auth/registro_viajero.php';
                        break;
                    case 'hotel':
                        echo '<p>El panel de registro para clientes corporativos aún no está disponible</p>';
                        echo '<a href = "/?url=auth/registro">Volver al registro</a>';
                        break;
                    default:
                        echo "<p>Rol no válido.</p>";
                        include __DIR__ . '/../views/auth/registro.php';
                        break;
                }
                return;
            }
           // Segundo paso: procesar el formulario completo
           $rol = $_POST['rol'] ?? '';

           switch($rol){
            case 'administrador':
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $nombre = $_POST['nombre'] ?? '';

                if(empty($email) || empty($password) || empty($nombre)){
                    echo "<p>Faltan datos obligatorios para el administrador</p>";
                    echo "<a href= '/?url=auth/registro'>Volver al registro</a>";
                    return;
                }
                $adminModel = new Admin();
                $resultado = $adminModel->registrarAdmin($nombre, $email, $password, $rol);

                if($resultado){
                    echo "<p>Administrador registrado correctamente</p>";
                    echo "<a href = '/?url=auth/login'>Ir al login</a>";
                }else{
                    echo "<p>Error al registrar el administrador.</p>";
                }
                break;
            case 'viajero':
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $nombre = $_POST['nombre_cliente'] ?? '';
                $apellido1 = $_POST['apellido1'] ?? '';
                $apellido2 = $_POST['apellido2'] ?? '';
                $direccion = $_POST['direccion'] ?? '';
                $codigo_postal = $_POST['codigo_postal'] ?? '';
                $pais = $_POST['pais'] ?? '';
                $ciudad = $_POST['ciudad'] ?? '';
                 if (
                    empty($email) || empty($password) || empty($nombre) ||
                    empty($apellido1) || empty($apellido2) || empty($direccion) ||
                    empty($codigo_postal) || empty($pais) || empty($ciudad)
                ) {
                    echo "<p>Faltan datos obligatorios para el viajero.</p>";
                    echo '<a href="/?url=auth/registro">Volver al registro</a>';
                    return;
                }
                $viajeroModel = new Viajero();
                $resultado = $viajeroModel->registrarViajero(
                    $nombre, $apellido1, $apellido2, $email, $password,
                    $direccion, $codigo_postal, $pais, $ciudad
                );
                if($resultado){
                    echo "<p>Cliente particular reigstrado correctamente.</p>";
                    echo "<a href='/?url=auth/login'>Ir al login</a>";
                }else{
                    echo "<p>Error al registrar el cliente particular</p>";
                }
                break;
            default:
                echo "<p>Rol no válido o no soportado</p>";
                include __DIR__ . '/../views/auth/registro.php';
           }
        }else{
            include __DIR__ . '/../views/auth/registro.php';
        }
    }
}           
?>
