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
                'ciudad'       => $_POST['ciudad'],
            ];

            // Solo actualizar contraseña si el usuario escribió una nueva
            if (!empty($_POST['password'])) {
                $datos['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
}

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
        $hotelModel   = new Hotel();              
        $reservaModel = new Viajero_Reserva();
        

        // Validación mínima
        $id_hotel        = $_POST['id_hotel']            ?? null;
        $id_tipo_reserva = $_POST['id_tipo_reserva']     ?? null;
        $id_vehiculo     = $_POST['id_vehiculo']         ?? null;
        $fecha_llegada   = $_POST['fecha_entrada']       ?? null;
        $hora_llegada    = $_POST['hora_entrada']        ?? null;
        $fecha_salida    = $_POST['fecha_vuelo_salida']  ?? null;
        $hora_salida     = $_POST['hora_vuelo_salida']   ?? null;
        $hora_recogida   = $_POST['hora_recogida']       ?? null;


        if (!$id_hotel || !$id_tipo_reserva || !$id_vehiculo) {
            echo "<p>Faltan datos obligatorios (hotel / tipo / vehículo).</p>";
            echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
            return;
        }

        

        switch ($id_tipo_reserva) {

            //Hotel → Aeropuerto (tipo 1)
            case 1: 
                //Validaciones de horas
                if ($hora_salida && $hora_recogida) {
                    // Hora de recogida NO puede ser mayor que hora de vuelo
                    if ($hora_recogida > $hora_salida) {
                        echo "<p style='color:red; font-weight:bold;'>
                                La hora de recogida no puede ser posterior a la hora de salida del vuelo.
                            </p>";
                        echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                        return;
                    }
                    // Hora de recogida NO puede ser igual a hora de vuelo (hay que darle margen)
                    if ($hora_recogida == $hora_salida) {
                        echo "<p style='color:red; font-weight:bold;'>
                                La hora de recogida no puede ser igual a la hora de salida del vuelo.
                            </p>";
                        echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                        return;
                    }
                }
                break;
            //Aeropuerto → Hotel (tipo 2)
            case 2:
                //No hay validaciones específicas aún
                break;

            //Ida y vuelta (tipo 3)
            case 3:
                //Validacion horas en vuelo de salida
                if ($hora_salida && $hora_recogida) {

                    //Hora recogida no puede ser mayor o igual que hora salida
                    if ($hora_recogida > $hora_salida) {
                        echo "<p style='color:red;font-weight:bold;'>
                                La hora de recogida no puede ser posterior a la hora de salida del vuelo.
                            </p>";
                        echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                        return;
                    }

                    //Hora recogida no puede ser igual que hora salida
                    if ($hora_recogida == $hora_salida) {
                        echo "<p style='color:red;font-weight:bold;'>
                                La hora de recogida no puede ser igual a la hora de salida del vuelo.
                            </p>";
                        echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                        return;
                    }
                }


                //Validacion de vuelo de ida vs vuelta
                //Vuelo de salida no puede ser posterior o igual al vuelo de llegada
                if ($fecha_salida > $fecha_llegada) {
                    echo "<p style='color:red;font-weight:bold;'>
                            La fecha del vuelo de ida no puede ser posterior a la fecha del vuelo de vuelta.
                        </p>";
                    echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                    return;
                }


                //Validacion de vuelo de salida misma fecha que vuelo de llegada
                if ($fecha_salida == $fecha_llegada) {

                    // Hora salida NO puede ser mayor que hora llegada
                    if ($hora_salida > $hora_llegada) {
                        echo "<p style='color:red;font-weight:bold;'>
                                La hora del vuelo de ida no puede ser posterior a la hora del vuelo de vuelta.
                            </p>";
                        echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                        return;
                    }

                    // Hora salida NO puede ser igual a hora llegada
                    if ($hora_salida == $hora_llegada) {
                        echo "<p style='color:red;font-weight:bold;'>
                                La hora del vuelo de ida no puede ser igual a la hora del vuelo de vuelta.
                            </p>";
                        echo "<a href='/?url=viajero/crearReserva'>Volver</a>";
                        return;
                    }
                }

                break;
            default:
                // Tipos sin validación especial
        }

        //Obtener id_zona del hotel seleccionado
        $id_zona = $hotelModel->obtenerZonaIdPorHotelId($id_hotel);  // ✅ aquí estaba el typo

        // Si tu BD aún usa 'id_destino' con FK a zona, esto lo llena automáticamente
        $localizador   = $reservaModel->crearlocalizador();
        $fecha_actual  = date('Y-m-d H:i:s');

        $datos = [
            ':localizador'          => $localizador,
            ':id_hotel'             => $id_hotel,
            ':id_tipo_reserva'      => $id_tipo_reserva,
            ':email_cliente'        => $_SESSION['user_email'] ?? '',
            ':fecha_reserva'        => $fecha_actual,
            ':fecha_modificacion'   => $fecha_actual,
            ':id_destino'           => $id_zona ?? null,  //zona del hotel
            ':fecha_entrada'        => !empty($_POST['fecha_entrada']) ? $_POST['fecha_entrada'] : null,
            ':hora_entrada'         => !empty($_POST['hora_entrada']) ? $_POST['hora_entrada'] : null,
            ':numero_vuelo_entrada' => !empty($_POST['numero_vuelo_entrada']) ? $_POST['numero_vuelo_entrada'] : null,
            ':origen_vuelo_entrada' => !empty($_POST['origen_vuelo_entrada']) ? $_POST['origen_vuelo_entrada'] : null,
            ':hora_vuelo_salida'    => !empty($_POST['hora_vuelo_salida']) ? $_POST['hora_vuelo_salida'] : null,
            ':fecha_vuelo_salida'   => !empty($_POST['fecha_vuelo_salida']) ? $_POST['fecha_vuelo_salida'] : null,
            ':numero_vuelo_salida'  => !empty($_POST['numero_vuelo_salida']) ? $_POST['numero_vuelo_salida'] : null,
            ':hora_recogida'        => !empty($_POST['hora_recogida']) ? $_POST['hora_recogida'] : null,
            ':num_viajeros'         => (int)($_POST['num_viajeros'] ?? 1),
            ':id_vehiculo'          => $id_vehiculo,
        ];

        $resultado = $reservaModel->crearReserva($datos);

        if ($resultado) {

            // Preparar datos para la vista
            $localizador         = $localizador;
            $email               = $_SESSION['user_email'];
            $hotel_nombre        = $hotelModel->obtenerNombrePorId($id_hotel);
            $num_viajeros        = (int)($_POST['num_viajeros'] ?? 1);

            // Obtener texto del tipo de reserva
            require_once __DIR__ . '/../models/tipo_reserva.php';
            $tipoModel = new TipoReserva();
            $tipos = $tipoModel->listarTipos();
            $tipo_reserva_texto = $tipos[$id_tipo_reserva - 1]['descripcion'] ?? "—";

            // Mostrar vista
            include __DIR__ . '/../views/viajero/viajero_reserva_confirmacion.php';
            exit;
        }
    }
}
?>