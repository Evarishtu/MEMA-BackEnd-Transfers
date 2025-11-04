<?php 
class AdminController{
    public function dashboard(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }
        include __DIR__ . '/../views/admin/dashboard.php';
    }
}

?>