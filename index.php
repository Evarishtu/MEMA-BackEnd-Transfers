<?php 
//==============================================
// Archivo principal de entrada (Enrutador MVC)
//==============================================


//Cargar la configuración y controladores

define('BASE_PATH', __DIR__ . '/src');

require_once BASE_PATH . '/config/database.php';

//Capturar la ruta
$url = $_GET['url'] ?? '';

if(empty($url)){
    include BASE_PATH . '/views/home.php';
    exit;
}

// Dividir la URL en partes
$partes = explode('/', $url);
$modulo = strtolower($partes[0] ?? '');
$accion = $partes[1] ?? 'index';

$controllerName = ucfirst($modulo) . 'Controller';
$controllerFile = BASE_PATH . "/controllers/{$controllerName}.php";

// Verificar que el controlador existe
if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "<h2>Error 404: Controlador <strong>$controllerName</strong> no encontrado.</h2>";
    echo "<a href='/'>Volver al inicio</a>";
    exit;
}

// Cargar el controlador
require_once $controllerFile;

// Crear instancia de la clase
if (!class_exists($controllerName)) {
    echo "<p>Error: la clase <strong>$controllerName</strong> no existe en el archivo.</p>";
    exit;
}

$controller = new $controllerName();

// Verificar que la acción existe
if (!method_exists($controller, $accion)) {
    http_response_code(404);
    echo "<h2>Error 404: Acción <strong>$accion</strong> no encontrada en <strong>$controllerName</strong>.</h2>";
    echo "<p>Ruta solicitada: <strong>$url</strong></p>";
    echo "<a href='/~uocx5/'>Volver al inicio</a>";
    exit;
}

// Llamar al método
$controller->$accion();
?>
