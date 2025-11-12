<?php
require_once __DIR__ . '/../models/vehiculo.php';

class VehiculoController {

    // Mostrar todos los vehículos
    public function listarvehiculos() {
        $vehiculoModel = new Vehiculo();
        $vehiculos = $vehiculoModel->listarVehiculos();
        include __DIR__ . '/../views/vehiculo/listar-vehiculo.php';
    }

    // Mostrar formulario de creación
    public function crearvehiculo() {
        include __DIR__ . '/../views/vehiculo/vehiculo-form.php';
    }

    // Guardar un nuevo vehículo
    public function guardarvehiculo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');
            $email_conductor = trim($_POST['email_conductor'] ?? '');
            $password_conductor = trim($_POST['password_conductor'] ?? '');

            if (empty($descripcion)) {
                echo "<p>Debe ingresar una descripción.</p>";
                echo "<a href='/?url=vehiculo/crearvehiculo'>Volver</a>";
                exit;
            }

            $vehiculoModel = new Vehiculo();
            $vehiculoModel->crearVehiculo($descripcion, $email_conductor, $password_conductor);

            // Redirigimos correctamente al listado
            header('Location: /?url=vehiculo/listarvehiculos');
            exit;
        }
    }

    // Mostrar formulario para editar
    public function editarvehiculo() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "<p>Error: ID de vehículo no proporcionado.</p>";
            exit;
        }

        $vehiculoModel = new Vehiculo();
        $vehiculo = $vehiculoModel->obtenerVehiculoPorId($id);

        if (!$vehiculo) {
            echo "<p>Vehículo no encontrado.</p>";
            exit;
        }

        include __DIR__ . '/../views/vehiculo/vehiculo-form.php';
    }

    // Actualizar vehículo existente
    public function actualizarvehiculo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!$id || empty($descripcion)) {
                echo "<p>Datos incompletos.</p>";
                echo "<a href='/?url=vehiculo/listarvehiculos'>Volver</a>";
                exit;
            }

            $vehiculoModel = new Vehiculo();
            $vehiculoModel->actualizarVehiculo($id, $descripcion);

            header('Location: /?url=vehiculo/listarvehiculos');
            exit;
        }
    }

    // Eliminar vehículo
    public function eliminarvehiculo() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "<p>Error: ID de vehículo no proporcionado.</p>";
            exit;
        }

        $vehiculoModel = new Vehiculo();
        $vehiculoModel->eliminarVehiculo($id);

        header('Location: /?url=vehiculo/listarvehiculos');
        exit;
    }

}
?>
