<?php 
require_once __DIR__ . '/../models/admin.php';

class AuthController{
    // Registro
    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $rol = $_POST['rol'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $nombre = $_POST['nombre'] ?? '';

            if(empty($rol) || empty($email) || empty($password)){
                echo "<p>Faltan datos obligatorios.</p>";
                return;
            }
            switch($rol){
                case 'administrador':
                    $adminModel = new Admin();
                    $resultado = $adminModel->registrarAdmin($nombre, $email, $password, $rol);
                    if($resultado){
                        echo "<p>Adminstrador registrado correctamente.</p>";
                        echo "<a href = '../views/auth/login.php'>Ir al login</a>";
                    }else {
                        echo "<p>Error al registrar el administrador.</p>";
                    }
                    break;
                case 'viajero':
                    echo "<p>El panel para los usuarios particulares no está desarrollado.</p>";
                    break;
                case 'hotel':
                    echo "<p>El panel para los usuarios corporativos no está desarrollado</p>";
                    break;
                default:
                    echo "<p>Rol no válido.</p>";
            }
        }else {
            include __DIR__ . '/../views/auth/registro.php';
        }
    }
    // Login
    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $rol = $_POST['rol'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if(empty($rol) || empty ($email) || empty($password)){
                echo "<p>Por favor, rellene todos los campos.</p>";
            }
            switch($rol){
                case 'administrador':
                    $adminModel = new Admin();
                    $admin = $adminModel->autenticarAdmin($email, $password);
                    if($admin){
                        session_start();
                        $_SESSION['user_id'] = $admin['id_admin'];
                        $_SESSION['user_nombre'] = $admin['nombre'];
                        $_SESSION['rol'] = $admin['rol'];

                        header('Location: ../views/admin/dashboard.php');
                        exit;
                    }else{
                        echo "<p>Credenciales incorrectas. Intenta de nuevo.</p>";
                        include __DIR__ . '/../views/auth/login.php';
                    }
                    break;
                case 'viajero':
                    echo "<p>Login de cliente aún no implementado.</p>";
                    break;
                case 'hotel':
                    echo "<p>Login de cliente corporativo no se implementa en este producto</p>";
                default:
                    echo "<p>Rol no reconocido.</p>";
            }
        }else {
        include __DIR__ . '/../views/auth/login.php';
        }
    }
    // Logout
    public function logout(){
        session_start();
        session_destroy();
        header('Location: ../views/auth/login.php');
        exit;
    }
}
?>
