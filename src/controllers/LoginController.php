<?php 
require_once __DIR__ . '/../models/admin.php';
require_once __DIR__ . '/../models/viajero.php';

class LoginController {
    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $rol = $_POST['rol'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if(empty($rol) || empty($email) || empty($password)){
                // echo "<p>Por favor, rellene todos los campos.</p>";
                header('Location: /?url=login/login');
                exit;
            }
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
            switch($rol){
                case 'administrador': 
                    $adminModel = new Admin();
                    $admin = $adminModel->autenticarAdmin($email, $password);
                    if($admin){
                        
                        $_SESSION['user_id'] = $admin['id_admin'];
                        $_SESSION['user_nombre'] = $admin['nombre'];
                        $_SESSION['rol'] = 'administrador';
                        header('Location: /?url=admin/dashboard');
                        exit;
                    }else{
                        // echo "<p>Credenciales incorrectas.</p>";
                        header('Location: /?url=login/login');
                        exit;
                    }
                    break;
                case 'viajero':
                    $viajeroModel = new Viajero();
                    $viajero = $viajeroModel->autenticarViajero($email, $password);
                    if($viajero){
                        
                        $_SESSION['user_id'] = $viajero['id_viajero'];
                        $_SESSION['user_nombre'] = $viajero['nombre_cliente'];
                        $_SESSION['rol'] = 'viajero';
                        header('Location: /?url=viajero/perfil');
                        exit;
                    }else{
                        // echo "<p>Credenciales incorrectas.</p>";
                        header('Location: /?url=login/login');
                        exit;
                    }
                    break;
                default:
                    // echo "<p>Rol no reconocido</p>";
                    header('Location: /?url=login/login');
                    exit;
            }
        }
            include __DIR__ . '/../views/auth/login.php';  
    }
    public function logout(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        session_destroy();
        header('Location: /?url=login/login');
        exit;
    }
}
?>