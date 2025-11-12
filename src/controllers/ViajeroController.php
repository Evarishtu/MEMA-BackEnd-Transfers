<?php 
require_once __DIR__ . '/../models/hotel.php';
require_once __DIR__ . '/../models/reserva.php';
require_once __DIR__ . '/../models/tipo_reserva.php';
require_once __DIR__ . '/../models/vehiculo.php';
require_once __DIR__ . '/../models/viajero.php';
require_once __DIR__ . '/../models/viajero_reserva.php';

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
    // INFORMACIÓN PERSONAL
    // ===============================
    public function informacionPersonal() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $viajeroModel = new viajero();
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

    // ===============================
    // MOSTRAR RESERVAS 
    // ===============================
    public function obtenerReservasPorViajero() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $reservaViajeroModel = new Viajero_Reserva();
        $email  = $_SESSION['user_email'];
        $nombre = $_SESSION['user_nombre'];
        $origen_admin   = 'admin';
        $origen_viajero = 'viajero';

        $reservasViajero = $reservaViajeroModel->obtenerReservasPorOrigen($email, $origen_viajero);
        $reservasAdmin   = $reservaViajeroModel->obtenerReservasPorOrigen($email, $origen_admin);


        include __DIR__ . '/../views/viajero/viajero_reservas.php';
    }
    
    // ===============================
    // CREAR RESERVA
    // ===============================

    public function crearReserva() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificamos que el usuario sea viajero
        if (empty($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
            header('Location: /?url=login/login');
            exit;
        }

        // Cargamos los modelos necesarios
        $hotelModel       = new Hotel();
        $vehiculoModel    = new Vehiculo();
        $tipoReservaModel = new TipoReserva();

        // Obtenemos los datos desde la base de datos
        $hoteles      = $hotelModel->listarHoteles();
        $vehiculos    = $vehiculoModel->listarVehiculos();
        $tiposReserva = $tipoReservaModel->listarTipos();

        // Cargamos el email del usuario desde la sesión
        $email_cliente = $_SESSION['user_email'];

        // Incluimos la vista de creación de reserva
        include __DIR__ . '/../views/viajero/viajero_crear_reserva.php';
    }


    public function guardarReserva() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "<p>Método no permitido.</p>";
            return;
        }

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['rol']) || $_SESSION['rol'] !== 'viajero') {
            header('Location: /?url=login/login');
            exit;
        }

        require_once __DIR__ . '/../models/viajero_reserva.php';
        $hotelModel   = new Hotel();              // ✅ nombre correcto
        $reservaModel = new Viajero_Reserva();

        // Validación mínima
        $id_hotel        = $_POST['id_hotel']        ?? null;
        $id_tipo_reserva = $_POST['id_tipo_reserva'] ?? null;
        $id_vehiculo     = $_POST['id_vehiculo']     ?? null;

        if (!$id_hotel || !$id_tipo_reserva || !$id_vehiculo) {
            echo "<p>Faltan datos obligatorios (hotel / tipo / vehículo).</p>";
            echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
            return;
        }

        // 🔎 Obtener id_zona del hotel seleccionado
        $id_zona = $hotelModel->obtenerZonaIdPorHotelId($id_hotel);  // ✅ aquí estaba el typo

        // Si tu BD aún usa 'id_destino' con FK a zona, esto lo llena automáticamente
        $localizador   = strtoupper(substr(uniqid(), -8));
        $fecha_actual  = date('Y-m-d H:i:s');

        $datos = [
            ':localizador'          => $localizador,
            ':id_hotel'             => $id_hotel,
            ':id_tipo_reserva'      => $id_tipo_reserva,
            ':email_cliente'        => $_SESSION['user_email'] ?? '',
            ':fecha_reserva'        => $fecha_actual,
            ':fecha_modificacion'   => $fecha_actual,
            ':id_destino'           => $id_zona ?? null,  // 👈 zona del hotel
            ':fecha_entrada'        => !empty($_POST['fecha_entrada']) ? $_POST['fecha_entrada'] : null,
            ':hora_entrada'         => !empty($_POST['hora_entrada']) ? $_POST['hora_entrada'] : null,
            ':numero_vuelo_entrada' => !empty($_POST['numero_vuelo_entrada']) ? $_POST['numero_vuelo_entrada'] : null,
            ':origen_vuelo_entrada' => !empty($_POST['origen_vuelo_entrada']) ? $_POST['origen_vuelo_entrada'] : null,
            ':hora_vuelo_salida'    => !empty($_POST['hora_vuelo_salida']) ? $_POST['hora_vuelo_salida'] : null,
            ':fecha_vuelo_salida'   => !empty($_POST['fecha_vuelo_salida']) ? $_POST['fecha_vuelo_salida'] : null,
            ':numero_vuelo_salida'  => !empty($_POST['numero_vuelo_salida']) ? $_POST['numero_vuelo_salida'] : null,
            ':hora_recogida'        => !empty($_POST['hora_recogida']) ? $_POST['hora_recogida'] : null,
            ':num_viajeros'         => (int)($_POST['num_viajeros'] ?? 1),
            ':id_vehiculo'          => $id_vehiculo
        ];

        $ok = $reservaModel->crearReserva($datos);

        if ($ok) {
            // ✅ Mostrar popup y volver al formulario o dashboard
            echo "
                <script>
                    alert('✅ Reserva creada con éxito');
                    window.location.href = '/?url=viajero/crearReserva';
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('❌ Error al guardar la reserva. Revisa los datos.');
                    window.location.href = '/?url=viajero/crearReserva';
                </script>
            ";
            exit;
}
    }



}
?>