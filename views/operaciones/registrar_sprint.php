<?php
require_once "../../models/database/registro_db_interface.php";
require_once "../../models/database/registro_db.php";
require_once "../../models/entities/sprint.php";
require_once "../../models/mappers/sprint_mappers.php";
require_once "../../models/repositories/sprints_repository/sprint_repository_interface.php";
require_once "../../models/repositories/sprints_repository/sprint_repository.php";
require_once "../../models/config/models_config.php";
require_once "../../controllers/mappers/sprints_mapper_controller.php";
require_once "../../controllers/sprints/sprints_controller_interface.php";
require_once "../../controllers/sprints/sprints_controller.php";
require_once "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
$fecha_fin = trim($_POST['fecha_fin'] ?? '');

// Detiene el flujo y retorna al formulario si alguno de los campos obligatorios llega vacío
if ($nombre === '' || $fecha_inicio === '' || $fecha_fin === '') {
    header("Location: ../sprint_form.php?error=datos");
    exit;
}

// Valida que las fechas sean en un formato dd/mm/año
if ($fecha_fin < $fecha_inicio) {
    header("Location: ../sprint_form.php?error=fechas");
    exit;
}

$controller = ControllersConfig::get_sprints_controller();
$ok = $controller->save_sprint($_POST);

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
