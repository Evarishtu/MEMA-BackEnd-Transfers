<?php
require_once __DIR__ . '/../models/tipo_reserva.php';

class ReservaTipoController {

    // Mostrar todos los tipos de reservas
    public function index() {
        $reservatipoModel = new TipoReserva();
        $reservatipo = $reservatipoModel->listarTipos();

        include __DIR__ . '/../views/reservatipo/listar-tipo-reserva.php';
    }

    // Crear un nuevo tipo de reserva
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!empty($descripcion)) {
                $reservatipoModel = new TipoReserva();
                $reservatipoModel->create_reservatipo($descripcion);
                header("Location: ?url=reservatipo/index");
                exit;
            } else {
                $error = "⚠️ La descripción no puede estar vacía.";
            }
        }

        include __DIR__ . '/../views/reservatipo/reservatipo_form.php';
    }

    // Editar una reservatipo existente
    public function edit() {
        $reservatipoModel = new TipoReserva();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: ?url=reservatipo/index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!empty($descripcion)) {
                $reservatipoModel->update_reservatipo($id, $descripcion);
                header("Location: ?url=reservatipo/index");
                exit;
            } else {
                $error = "⚠️ La descripción no puede estar vacía.";
            }
        }

        $reservatipo = $reservatipoModel->get_reservatipoById($id);
        include __DIR__ . '/../views/reservatipo/reservatipo_form.php';
    }

    // Eliminar una reservatipo
    public function delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $reservatipoModel = new TipoReserva();
            $reservatipoModel->delete_reservatipo($id);
        }

        header("Location: ?url=reservatipo/index");
        exit;
    }
}
?>
