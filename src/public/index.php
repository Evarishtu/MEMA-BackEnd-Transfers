<?php 
//==============================================
// Archivo principal de entrada (Enrutador MVC)
//==============================================


//Cargar la configuración y controladores

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

// Capturar la ruta (?url=modulo/accion)
$url = $_GET['url'] ?? ''; 

if (empty($url)){
    include __DIR__ . '/../views/home.php';
    exit;
}

$partes = explode('/', $url);
$modulo = $partes[0] ?? 'auth';
$accion = $partes[1] ?? 'login';

switch ($modulo){
    case 'auth':
        $controller = new AuthController();
        switch ($accion){
            case 'login':
                $controller->login();
                break;
            case 'registro':
                $controller->registrar();
                break;
            case 'logout':
                $controller->logout();
                break;
            default:
                echo "<p>Ruta de autenticación no válida. </p>";
        }
        break;
    
    case 'admin':
        session_start();
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            echo "<p>Acceso denegado. Inice sesión como administrador.</p>";
            echo '<a href="/?url=auth/login">Ir al login</a>';
            exit;
        }
    switch($accion){
        case 'dashboard':
            include __DIR__ . '/../views/admin/dashboard.php';
            break;
        case 'crear-reserva':
            include __DIR__ . '/../views/admin/crear-reserva.php';
            break;
        case 'listar-reservas':
            include __DIR__ . '/../views/admin/listar-reservas.php';
            break;
        default: 
            echo "<p>Ruta de administración no válida </p>";
    }
    break;
    
    default:
        http_response_code(404);
        echo "<h2> Página no encontrada</h2>";
        echo "<p>La ruta solicitada no existe: <strong>$url</strong></p>";
        echo "<a href = '/'>Volver al inicio</a>";
}
?>
