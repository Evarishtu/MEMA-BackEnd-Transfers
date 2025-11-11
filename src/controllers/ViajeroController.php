<?php 
require_once __DIR__ . '/../models/hotel.php';
require_once __DIR__ . '/../models/reserva.php';
require_once __DIR__ . '/../models/tipo_reserva.php';
require_once __DIR__ . '/../models/vehiculo.php';
require_once __DIR__ . '/../models/viajero.php';

class ViajeroController {

    // ===============================
    // DASHBOARD PRINCIPAL DEL VIAJERO
    // ===============================
    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Seguridad básica: solo viajeros pueden acceder
        if (empty($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
            header('Location: /?url=login/login');
            exit;
        }

        include __DIR__ . '/../views/viajero/viajero_dashboard.php';
    }

    // ===============================
    // MOSTRAR RESERVAS DEL VIAJERO
    // ===============================
    public function obtenerReservasPorViajero() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $reservaModel = new Reserva();
        $reservas = $reservaModel->obtenerReservasPorViajero($_SESSION['user_email']);

        include __DIR__ . '/../views/viajero/reservas.php';
    }

    // ===============================
    // CREAR RESERVA
    // ===============================
    public function crearReserva() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        include __DIR__ . '/../views/viajero/crear_reserva.php';
    }

    // ===============================
    // INFORMACIÓN PERSONAL
    // ===============================
    public function informacionPersonal() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $viajeroModel = new Viajero();
        $email = $_SESSION['user_email'];
        $viajero = $viajeroModel->obtenerViajeroPorEmail($email); // ✅ usar esta

        include __DIR__ . '/../views/viajero/viajero_info_personal.php';
    }

    // ===============================
    // ACTUALIZAR INFORMACIÓN PERSONAL
    // ===============================
    public function actualizarInformacionPersonal() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $viajeroModel = new Viajero();
        $id = $_POST['id_viajero'];
        
        $datos = [
            'nombre'       => $_POST['nombre'],
            'apellido1'    => $_POST['apellido1'],
            'apellido2'    => $_POST['apellido2'],
            'direccion'    => $_POST['direccion'],
            'codigoPostal' => $_POST['codigoPostal'],
            'pais'         => $_POST['pais'],
            'ciudad'       => $_POST['ciudad']
        ];

        $viajeroModel->actualizarViajero($id, $datos);
        header('Location: /?url=viajero/informacionPersonal');
        exit;
    }
}

}
?>