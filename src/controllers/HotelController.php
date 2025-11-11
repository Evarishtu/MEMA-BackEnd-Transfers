<?php

require_once __DIR__ . '/../models/hotel.php';
require_once __DIR__ . '/../models/zona.php';

class HotelController {

    // ===============================
    // LISTAR TODOS LOS HOTELES
    // ===============================
    public function listarHoteles() {

        $hotelModel = new Hotel();

        $hoteles = $hotelModel->listarHotelesConZona(); 
        include __DIR__ . '/../views/hotel/hotel_listar.php';
    }

    // ===============================
    // MOSTRAR FORMULARIO PARA CREAR HOTEL
    // ===============================
    public function listarZonas() {
        $zonaModel = new Zona();
        $zonas = $zonaModel->get_zonasAll(); // carga las zonas para el <select>
        include __DIR__ . '/../views/hotel/hotel_crear.php';
    }

    // ===============================
    // GUARDAR NUEVO HOTEL
    // ===============================
    public function crearHotel() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hotelModel = new Hotel();

        $nombre  = $_POST['nombre'];
        $id_zona = $_POST['id_zona'];
        $comision = $_POST['comision'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];


        $hotelModel->registrarHotel($nombre, $id_zona, $comision, $usuario, $password);
    }

    header('Location: /?url=hotel/listarHoteles');
    exit;
    }

    // ===============================
    // ELIMINAR HOTEL
    // ===============================
    public function eliminarHotel() {
        if (isset($_GET['id'])) {
            $hotelModel = new Hotel();
            $hotelModel->eliminarHotel($_GET['id']);
        }

        header('Location: /?url=hotel/listarHoteles');
        exit;
    }

}

?>