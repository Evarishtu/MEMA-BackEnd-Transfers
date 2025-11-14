<?php 
require_once __DIR__ . '/../models/hotel.php';
require_once __DIR__ . '/../models/reserva.php';
require_once __DIR__ . '/../models/tipo_reserva.php';
require_once __DIR__ . '/../models/vehiculo.php';
require_once __DIR__ . '/../models/viajero.php';


class AdminController{
    public function dashboard(){
        include __DIR__ . '/../views/admin/dashboard.php';
    }
    public function crearReserva(){
        $tipoModel = new TipoReserva();
        $tipos_reserva = $tipoModel->listarTipos();
        
        include __DIR__ . '/../views/admin/crear_reserva_tipo.php';
    }
    public function crearReservaDatos(){
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && empty($_GET['email'])) {
        header('Location: /?url=admin/crearReserva');
        exit;
    }

    if (!empty($_POST['tipo_reserva'])) {
        $id_tipo_reserva = $_POST['tipo_reserva'];
    } else {
        $id_tipo_reserva = null;
    }

    $email_cliente_precargado = $_GET['email'] ?? '';

    $hotelModel = new Hotel();
    $hoteles = $hotelModel->listarHoteles();

    $vehiculoModel = new Vehiculo();
    $vehiculos = $vehiculoModel->listarVehiculos();

    include __DIR__ . '/../views/admin/crear_reserva_datos.php';
    }


    public function guardarReserva() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /?url=admin/crearReserva');
        exit;
    }

    $hotelModel   = new Hotel(); 
    $viajeroModel = new Viajero();
    $reservaModel = new Reserva();
    $tipoModel    = new TipoReserva();

    $email_cliente = $_POST['email_cliente'] ?? null;
    
    if (empty($email_cliente)) {
        echo "<p>Debe indicar un email de cliente.</p>";
        echo "<a href='/?url=admin/crearReserva'>Volver</a>";
        exit;
    }

    $tipo_reserva = $_POST['tipo_reserva'] ?? '';

    if (!$viajeroModel->existeEmail($email_cliente)) {
        header('Location: /?url=admin/crearViajero&email=' . urlencode($email_cliente) . '&tipo_reserva=' . urlencode($tipo_reserva));
        exit;
    }

    if (empty($tipo_reserva)) {
        echo "<p>Debe indicar un tipo de reserva.</p>";
        echo "<a href='/?url=admin/crearReserva'>Volver</a>";
        exit;
    }

    $id_hotel = $_POST['id_hotel'] ?? null;
    $numero_viajeros = $_POST['numero_viajeros'] ?? null;
    $id_vehiculo = $_POST['id_vehiculo'] ?? null;
    $fecha_actual = date('Y-m-d H:i:s');

    if (empty($id_hotel) || empty($id_vehiculo) || empty($numero_viajeros)) {
        echo "<p>Faltan datos obligatorios para crear la reserva.</p>";
        echo '<a href="/?url=admin/crearReserva">Volver</a>';
        exit;
    }

    // ----------- CAMPOS DEL TIPO DE RESERVA -----------
    $fecha_entrada = $hora_entrada = $numero_vuelo_entrada = $origen_vuelo_entrada = null;
    $fecha_vuelo_salida = $hora_vuelo_salida = $numero_vuelo_salida = $hora_recogida = null;

    if ($tipo_reserva == "1" || $tipo_reserva == "3") {
        $fecha_entrada        = $_POST['fecha_llegada'] ?? null;
        $hora_entrada         = $_POST['hora_llegada'] ?? null;
        $numero_vuelo_entrada = $_POST['numero_vuelo_llegada'] ?? null;
        $origen_vuelo_entrada = $_POST['origen_vuelo'] ?? null;
    }

    if ($tipo_reserva == "2" || $tipo_reserva == "3") {
        $fecha_vuelo_salida  = $_POST['fecha_salida'] ?? null;
        $hora_vuelo_salida   = $_POST['hora_salida'] ?? null;
        $numero_vuelo_salida = $_POST['numero_vuelo_salida'] ?? null;
        $hora_recogida       = $_POST['hora_recogida'] ?? null;
    }

    // ----------- OBTENER DESTINO (id_zona) -----------
    $id_zona = $hotelModel->obtenerZonaIdPorHotelId($id_hotel);
    $localizador_generado = $reservaModel->crearlocalizador();

    // ----------- DATOS PARA INSERTAR -----------
    $datos = [
        'localizador' => $localizador_generado,
        'id_hotel' => $id_hotel,
        'id_tipo_reserva' => $tipo_reserva,
        'email_cliente' => $email_cliente,
        'fecha_reserva' => $fecha_actual,
        'fecha_modificacion' => $fecha_actual, 
        'id_destino' => $id_zona,
        'fecha_entrada' => $fecha_entrada,
        'hora_entrada' => $hora_entrada,
        'numero_vuelo_entrada' => $numero_vuelo_entrada,
        'origen_vuelo_entrada' => $origen_vuelo_entrada,
        'hora_vuelo_salida' => $hora_vuelo_salida,
        'fecha_vuelo_salida' => $fecha_vuelo_salida,
        'numero_vuelo_salida' => $numero_vuelo_salida,
        'hora_recogida' => $hora_recogida,
        'num_viajeros' => $numero_viajeros,
        'id_vehiculo' => $id_vehiculo,
        'usuario_creacion' => 'admin'
    ];

    $resultado = $reservaModel->crearReserva($datos);

    if ($resultado) {

        // ---- PREPARAR VARIABLES PARA LA VISTA ----
        $localizador    = $localizador_generado;
        $email          = $email_cliente;
        $num_viajeros   = $numero_viajeros;
        $hotel_nombre   = $hotelModel->obtenerNombrePorId($id_hotel);

        $tipo = $tipoModel->listarTipos();
        $tipo_reserva_texto = $tipo[$tipo_reserva - 1]['descripcion'] ?? 'Desconocido';

        require_once __DIR__ . '/../utility/EnviarEmail.php';
        EmailHelper::enviarConfirmacionReserva(
            $email_cliente,
            'Cliente',
            $localizador,
            $tipo_reserva_texto,
            $hotel_nombre
        );

        // ---- MOSTRAR LA VISTA ----
        include __DIR__ . '/../views/admin/crear_reserva_confirmacion.php';

    } else {
        echo "<p>Error al guardar la reserva.</p>";
        echo '<a href="/?url=admin/crearReserva">Volver</a>';
    }
}

    public function crearViajero(){
        if(!isset($_SESSION)){
            session_start();
        }

        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }

        // Recuperar email y tipo_reserva desde la URL si existen
        $email_cliente_precargado = $_GET['email'] ?? '';
        $tipo_reserva = $_GET['tipo_reserva'] ?? '';

        include __DIR__ . '/../views/admin/crear_viajero.php';
    }
    public function guardarViajero(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=admin/dashboard');
            exit;
        }
        $viajeroModel = new Viajero();

        $nombre = $_POST['nombre'] ?? '';
        $apellido1 = $_POST['apellido1'] ?? '';
        $apellido2 = $_POST['apellido2'] ?? '';
        $email = $_POST['email'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $codigoPostal = $_POST['codigoPostal'] ?? '';
        $pais = $_POST['pais'] ?? '';
        $ciudad = $_POST['ciudad'] ?? '';
        $tipo_reserva = $_POST['tipo_reserva'] ?? '';

        $passwordTemporal = bin2hex(random_bytes(4));

        if (
        empty($email) || empty($nombre) || empty($apellido1) ||
        empty($direccion) || empty($codigoPostal) || empty($pais) || empty($ciudad)
        ) {
            echo "<p>Todos los campos son obligatorios.</p>";
            echo "<a href='/?url=admin/crearViajero'>Volver</a>";
            exit;
        }

        $resultado = $viajeroModel->registrarViajero(
        $nombre, $apellido1, $apellido2, $email, $passwordTemporal,
        $direccion, $codigoPostal, $pais, $ciudad
        );

        if ($resultado === "email_duplicado") {
            echo "<p>El email ya existe en el sistema.</p>";
            echo "<a href='/?url=admin/crearViajero'>Volver</a>";
            exit;
        }

        if ($resultado) {
            echo "<h2>Cliente registrado correctamente.</h2>";
            echo "<p>Contraseña temporal generada: <strong>{$passwordTemporal}</strong></p>";
            echo "<a href='/?url=admin/crearReservaDatos&email=" . urlencode($email) . "&tipo_reserva=" . urlencode($tipo_reserva) . "'>
            Volver a crear reserva con este cliente</a>";
            
        } else {
            echo "<p>Error al registrar el cliente.</p>";
            echo "<a href='/?url=admin/crearViajero'>Volver</a>";
        }
    }
    public function listarReservas(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }
        $reservaModel = new Reserva();
        $filtros = ['desde' => $_GET['desde'] ?? null,
                    'hasta' => $_GET['hasta'] ?? null,
                    'tipo' => $_GET['tipo'] ?? null,
                    'hotel' => $_GET['hotel'] ?? null,
                    'q' => $_GET['q'] ?? null];
        $reservas = $reservaModel->listarTodas($filtros);

        include __DIR__ . '/../views/admin/listar_reservas.php';
    }
    public function verReserva(){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }
        $id = $_GET['id'] ?? null;
        if (!$id){
            header('Location: /?url=admin/listarReservas');
            exit;
        }
        $reservaModel = new Reserva();
        $reserva = $reservaModel->obtenerPorId($id);

        include __DIR__ . '/../views/admin/ver_reserva.php';
    }
    public function editarReserva(){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }
        $id = $_GET['id'] ?? null;
        if(!$id){
            header('Location: /?url=admin/listarReservas');
            exit;
        }
        $reservaModel = new Reserva();
        $reserva = $reservaModel->obtenerPorId($id);

        $hotelModel = new Hotel();
        $hoteles = $hotelModel->listarHoteles();

        $vehiculoModel = new Vehiculo();
        $vehiculos = $vehiculoModel->listarVehiculos();

        $tipoModel = new TipoReserva();
        $tipos_reserva = $tipoModel->listarTipos();

        include __DIR__ . '/../views/admin/editar_reserva.php';
    }
    public function actualizarReserva(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=admin/listarReservas'); 
            exit;
        }
            $datos = [
            'id_reserva' => $_POST['id_reserva'] ?? null,
            'id_hotel' => $_POST['id_hotel'] ?? null,
            'id_tipo_reserva' => $_POST['id_tipo_reserva'] ?? null,
            'email_cliente' => $_POST['email_cliente'] ?? null,
            'fecha_entrada' => $_POST['fecha_entrada'] ?? null,
            'hora_entrada' => $_POST['hora_entrada'] ?? null,
            'numero_vuelo_entrada' => $_POST['numero_vuelo_entrada'] ?? null,
            'origen_vuelo_entrada' => $_POST['origen_vuelo_entrada'] ?? null,
            'fecha_vuelo_salida' => $_POST['fecha_vuelo_salida'] ?? null,
            'hora_vuelo_salida' => $_POST['hora_vuelo_salida'] ?? null,
            'numero_vuelo_salida' => $_POST['numero_vuelo_salida'] ?? null,
            'hora_recogida' => $_POST['hora_recogida'] ?? null,
            'num_viajeros' => $_POST['num_viajeros'] ?? null,
            'id_vehiculo' => $_POST['id_vehiculo'] ?? null
        ];
        $reservaModel = new Reserva();
        $ok = $reservaModel->actualizarReserva($datos);

        if($ok){
            header('Location: /?url=admin/verReserva$id=' .urlencode($datos['id_reserva']));
        }else{
            echo "<p>Error al actualizar la reserva</p>";
            echo "<a href='/?url=admin/listarReservas'>Volver</a>";
        }
    }
    public function cancelarReserva(){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id){
            header('Location: /?url=admin/listarReservas');
            exit;
        }
        $reservaModel = new Reserva();
        $ok = $reservaModel->eliminarReserva($id);

        if($ok){
            header('Location: /?url=admin/listarReservas');
        }else{
            echo "<p>No se pudo eliminar la reserva</p>";
            echo "<a href='/?url=admin/listarReservas'>Volver</a>";
        }
    }
    public function calendario(){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador'){
            header('Location: /?url=login/login');
            exit;
        }
        $reservaModel = new Reserva();
        $eventos = $reservaModel->listarEventosCalendario();

        $vista = $_GET['vista'] ?? 'semana';
        $fecha_base = $_GET['fecha'] ?? date('Y-m-d');

        include __DIR__ . '/../views/admin/calendario.php';
    } 

    public function informacionPersonal() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: /?url=login/login');
            exit;
        }

        require_once __DIR__ . '/../models/admin.php';
        $adminModel = new Admin();
        $admin = $adminModel->InfoAdminPorEmail($_SESSION['user_email']);

        include __DIR__ . '/../views/admin/admin_info_personal.php';
    }


    public function actualizarInformacionPersonal() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: /?url=login/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=admin/informacionPersonal');
            exit;
        }

        require_once __DIR__ . '/../models/admin.php';
        $adminModel = new Admin();

        $id_admin = $_POST['id_admin'];

        // Recolectar los datos editables
        $datos = [
            'nombre'   => $_POST['nombre'],
            'email'    => $_POST['email'],
            'password' => $_POST['password']  // OJO: ya viene hash o texto plano
        ];

        // Si la contraseña ha cambiado, debemos hashearla
        if (!empty($datos['password'])) {

            // Obtener contraseña actual en BD
            $adminActual = $adminModel->obtenerAdminPorId($id_admin);

            if ($adminActual['password'] !== $datos['password']) {
                // Si son distintas, hasheamos la nueva
                $datos['password'] = password_hash($datos['password'], PASSWORD_BCRYPT);
            }
        }

        // Guardar cambios
        $ok = $adminModel->actualizarAdminCompleto($id_admin, $datos);

        if ($ok) {
            // Actualizar sesión con el nombre nuevo
            $_SESSION['user_nombre'] = $datos['nombre'];

            header('Location: /?url=admin/informacionPersonal');
            exit;
        } else {
            echo "<p>Error al actualizar la información.</p>";
            echo "<a href='/?url=admin/informacionPersonal'>Volver</a>";
        }
    }
    



}

?>