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

$id = (int)($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
$fecha_fin = trim($_POST['fecha_fin'] ?? '');

// Aborta y vuelve al listado si no existe un identificador válido para actualizar
if ($id <= 0) {
    header("Location: ../inicio.php?error=1");
    exit;
}
if ($nombre === '' || $fecha_inicio === '' || $fecha_fin === '') {
    header("Location: ../sprint_form.php?id=" . $id . "&error=datos");
    exit;
}
if ($fecha_fin < $fecha_inicio) {
    header("Location: ../sprint_form.php?id=" . $id . "&error=fechas");
    exit;
}

$controller = ControllersConfig::get_sprints_controller();
$ok = $controller->update_sprint($_POST);

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
