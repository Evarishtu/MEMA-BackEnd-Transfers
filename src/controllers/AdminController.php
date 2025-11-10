<?php 
require_once __DIR__ . '/../models/hotel.php';
require_once __DIR__ . '/../models/reserva.php';
require_once __DIR__ . '/../models/tipo_reserva.php';
require_once __DIR__ . '/../models/vehiculo.php';

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
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['tipo_reserva'])){
            header('Location: /?url=admin/crearReserva');
            exit;
        }
        $id_tipo_reserva = $_POST['tipo_reserva'];
        
        $hotelModel = new Hotel();
        $hoteles = $hotelModel->listarHoteles();
        // var_dump($tipo_reserva);

        $vehiculoModel = new Vehiculo();
        $vehiculos = $vehiculoModel->listarVehiculos();

        include __DIR__ . '/../views/admin/crear_reserva_datos.php';
    }
    public function guardarReserva(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=admin/crearReserva');
            exit;
        }
    
    $tipo_reserva = $_POST['tipo_reserva'] ?? '';
    $id_hotel = $_POST['id_hotel'] ?? null;
    $numero_viajeros = $_POST['numero_viajeros'] ?? null;
    $email_cliente = $_POST['email_cliente'] ?? null;
    $id_vehiculo = $_POST['id_vehiculo'] ?? null;
    $fecha_actual = date('Y-m-d H:i:s');
    
    if (empty($email_cliente) || empty($id_hotel) || empty($id_vehiculo) || empty($numero_viajeros)) {
        echo "<p>Faltan datos obligatorios para crear la reserva.</p>";
        echo '<a href="/?url=admin/crearReserva">Volver</a>';
        exit;
    }

    $fecha_entrada = $hora_entrada = $numero_vuelo_entrada = $origen_vuelo_entrada = null;
    $fecha_vuelo_salida = $hora_vuelo_salida = $numero_vuelo_salida = $hora_recogida = null;
    
    if($tipo_reserva == "1" || $tipo_reserva == "3"){
        $fecha_entrada = $_POST['fecha_llegada'] ?? null;
        $hora_entrada = $_POST['hora_llegada'] ?? null;
        $numero_vuelo_entrada = $_POST['numero_vuelo_llegada'] ?? null;
        $origen_vuelo_entrada = $_POST['origen_vuelo'] ?? null;
    }

    if($tipo_reserva == "2" || $tipo_reserva == "3"){
        $fecha_vuelo_salida = $_POST['fecha_salida'] ?? null;
        $hora_vuelo_salida = $_POST['hora_salida'] ?? null;
        $numero_vuelo_salida = $_POST['numero_vuelo_salida'] ?? null;
        $hora_recogida = $_POST['hora_recogida'] ?? null;
    }

     $datos = [
        'localizador' => strtoupper(uniqid('RES-')),
        'id_hotel' => $id_hotel,
        'id_tipo_reserva' => $tipo_reserva,
        'email_cliente' => $email_cliente,
        'fecha_reserva' => $fecha_actual,
        'fecha_modificacion' => null,
        'id_destino' => null,
        'fecha_entrada' => $fecha_entrada,
        'hora_entrada' => $hora_entrada,
        'numero_vuelo_entrada' => $numero_vuelo_entrada,
        'origen_vuelo_entrada' => $origen_vuelo_entrada,
        'hora_vuelo_salida' => $hora_vuelo_salida,
        'fecha_vuelo_salida' => $fecha_vuelo_salida,
        'numero_vuelo_salida' => $numero_vuelo_salida,
        'hora_recogida' => $hora_recogida,
        'num_viajeros' => $numero_viajeros,
        'id_vehiculo' => $id_vehiculo
    ];

        $reservaModel = new Reserva();
        $resultado = $reservaModel->crearReserva($datos);

        if($resultado){
            $hotelModel = new Hotel();
            $hotel_nombre = $hotelModel->obtenerNombrePorId($id_hotel);

            $tipoModel = new TipoReserva();
            $tipo = $tipoModel->listarTipos();
            $tipo_reserva_texto = $tipo[$tipo_reserva - 1]['Descripción'] ?? 'Desconocido';

            $localizador = $datos['localizador'];
            $email = $email_cliente;
            $num_viajeros = $numero_viajeros;

            include __DIR__ . '/../views/admin/crear_reserva_confirmacion.php';
        }else{
            echo "<p>Error al guardar la reserva.</p>";
            echo '<a href="/?url=admin/crearReserva">Volver</a>';
        }
    } 
}

?>