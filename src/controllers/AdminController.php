<?php 
require_once __DIR__ . '/../models/hotel.php';
require_once __DIR__ . '/../models/reserva.php';

class AdminController{
    public function dashboard(){
        include __DIR__ . '/../views/admin/dashboard.php';
    }
    public function crearReserva(){
        include __DIR__ . '/../views/admin/crear_reserva_tipo.php';
    }
    public function crearReservaDatos(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['tipo_reserva'])){
            echo('estas aqui');
            header('Location: /?url=admin/crearReserva');
            exit;
        }
        $tipo_reserva = $_POST['tipo_reserva'];
        $hotelModel = new Hotel();
        $hoteles = $hotelModel->listarHoteles();
        // var_dump($tipo_reserva);

        include __DIR__ . '/../views/admin/crear_reserva_datos.php';
    }
    public function guardarReserva(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: /?url=admin/crearReserva');
            exit;
        }
    
    $tipo_reserva = $_POST['tipo_reserva'] ?? '';
    $id_hotel = $_POST['id_hotel'] ?? null;
    $numero_viajeros = $_POST['numero_viajeros'] ?? '';
    $email_cliente = $_POST['email_cliente'] ?? '';
    $fecha_actual = date('Y-m-d H:i:s');

    $datos = [ 'localizador' => strtoupper(uniqid('RES-')), 
                'id_hotel' => $id_hotel, 
                'id_tipo_reserva' => $tipo_reserva, 
                'email_cliente' => $email_cliente, 
                'fecha_reserva' => $fecha_actual, 
                'fecha_modificacion' => '', 
                'id_destino' => '', 
                'fecha_entrada' => $_POST['fecha_llegada'] ?? null, 
                'hora_entrada' => $_POST['hora_llegada'] ?? null, 
                'numero_vuelo_entrada' => $_POST['numero_vuelo_llegada'] ?? null, 
                'origen_vuelo_entrada' => $_POST['origen_vuelo'] ?? null, 
                'hora_vuelo_salida' => $_POST['hora_salida'] ?? null, 
                'fecha_vuelo_salida' => $_POST['fecha_salida'] ?? null, 
                'numero_viajeros' => $numero_viajeros, 
                'hora_recogida' => $_POST['hora_recogida'] ?? null 
            ];

        $reservaModel = new Reserva();
        $resultado = $reservaModel->crearReserva($datos);

        if($resultado){
            $hotelModel = new Hotel();
            $hotel_nombre = $hotelModel->obtenerNombrePorId($id_hotel);

            $tipos = ['1' => 'Aeropuerto -> Hotel',
                    '2' => 'Hotel -> Aeropuerto',
                    '3' => 'Ida y vuelta'];
            $tipo_reserva_texto = $tipos[$tipo_reserva] ?? 'Desconocido';

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