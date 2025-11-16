<?php
require_once __DIR__ . '/../models/zona.php';

class ZonaController {

    // Mostrar todas las zonas
    public function index() {
        $zonaModel = new Zona();
        $zonas = $zonaModel->get_zonasAll();

        include __DIR__ . '/../views/zona/listar-zonas.php';
    }

    // Crear una nueva zona
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!empty($descripcion)) {
                $zonaModel = new Zona();
                $zonaModel->create_zona($descripcion);
                header("Location: ?url=zona/index");
                exit;
            } else {
                $error = "⚠️ La descripción no puede estar vacía.";
            }
        }

        include __DIR__ . '/../views/zona/zonas_form.php';
    }

    // Editar una zona existente
    public function edit() {
        $zonaModel = new Zona();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: ?url=zona/index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!empty($descripcion)) {
                $zonaModel->update_zona($id, $descripcion);
                header("Location: ?url=zona/index");
                exit;
            } else {
                $error = "⚠️ La descripción no puede estar vacía.";
            }
        }

        $zona = $zonaModel->get_zonasById($id);
        include __DIR__ . '/../views/zona/zonas_form.php';
    }

    // Eliminar una zona
    public function delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $zonaModel = new Zona();
            $zonaModel->delete_zona($id);
        }

        header("Location: ?url=zona/index");
        exit;
    }
}

?>