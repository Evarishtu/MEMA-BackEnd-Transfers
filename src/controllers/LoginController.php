<?php 
require_once __DIR__ . '/../models/usuario.php';
require_once __DIR__ . '/../models/hotel.php';

class LoginController {
    public function login(){
        include __DIR__ . '/../views/login/login.php';
    }
    public function autenticar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=login/login');
            exit;
        }

        $usuarioInput = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';

        if(empty($usuarioInput) || empty($password)){
            echo "<p>Debe ingresar usuario y contraseña</p>";
            echo "<a href='/?url=login/login'>Volver</a>";
            exit;
        }
        if(strpos($usuarioInput, '@') !== false){
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->obtenerPorEmail($usuarioInput);

            if($usuario && password_verify($password, $usuario['password'])){
                session_start();
                $_SESSION['rol'] = $usuario['tipo_usuario'];
                $_SESSION['user_id'] = $usuario['id_viajero'];
                $_SESSION['user_nombre'] = $usuario['nombre'];

                if($usuario['tipo_usuario'] === 'usuario_admin'){
                    header('Location: /?url=admin/dashboard');
                }else{
                    header('Location: /?url=reservas/misReservas');
                }
                exit;
            }else{
                echo "<p>Credenciales incorrectas</p>";
                echo "<a href= '/?url=login/login'>Volver</a>";
                exit;
            }
        }else{
            $hotelModel = new Hotel();
            $hotel = $hotelModel->obtenerPorUsuario($usuarioInput);

            if($hotel && password_verify($password, $hotel['password'])){
                session_start();
                $_SESSION['rol'] = 'hotel';
                $_SESSION['user_id'] = $hotel['id_hotel'];
                $_SESSION['user_nombre'] = $hotel['nome'];

                header('Location: /?url=hotel/dashboard');
                exit;
            } else {
                echo '<p>Credenciales incorrectas</p>';
                echo "<a href='/?url=login/login'>Volver</a>";
                exit;
            }
        }
    }
    public function logout(){
        session_start();
        session_destroy();
        header('Location: /?url=login/login');
        exit;
    }
}
?>