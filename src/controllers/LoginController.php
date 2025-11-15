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
                header('Location: /?url=login/login&error=1');
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
                        $_SESSION['user_id']     = $admin['id_admin'];
                        $_SESSION['user_nombre'] = $admin['nombre'];
                        $_SESSION['user_email']  = $admin['email'];
                        $_SESSION['rol']         = 'administrador';

                        header('Location: /?url=admin/dashboard');
                        exit;
                    } else {
                        header('Location: /?url=login/login&error=1');
                        exit;
                    }
                    break;
                case 'hotel':
                    // Aquí iría la lógica para autenticar a un cliente corporativo (hotel)
                case 'viajero':
                    $viajeroModel = new Viajero();
                    $viajero = $viajeroModel->autenticarViajero($email, $password);

                    if($viajero){
                        $_SESSION['user_id']     = $viajero['id_viajero'];
                        $_SESSION['user_nombre'] = $viajero['nombre'];
                        $_SESSION['user_email']  = $viajero['email'];
                        $_SESSION['rol']         = 'viajero';

                        header('Location: /?url=viajero/dashboard');
                        exit;
                    } else {
                        header('Location: /?url=login/login&error=1');
                        exit;
                    }
                    break;


                default:
                    header('Location: /?url=login/login&error=1');
                    exit;
            }
        }

        include __DIR__ . '/../views/auth/login.php';  
    }


    //Función para cerrar sesión
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