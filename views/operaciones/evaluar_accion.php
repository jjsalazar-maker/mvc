<?php
require_once "../../models/database/registro_db_interface.php";
require_once "../../models/database/registro_db.php";
require_once "../../models/entities/retro_items.php";
require_once "../../models/mappers/retro_mappers.php";
require_once "../../models/repositories/sprints_repository/retro_repository_interface.php";
require_once "../../models/repositories/sprints_repository/retro_repository.php";
require_once "../../models/config/models_config.php";
require_once "../../controllers/mappers/retro_mapper_controller.php";
require_once "../../controllers/retro_items/retro_controller_interface.php";
require_once "../../controllers/retro_items/retro_controller.php";
require_once "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$sprint_id = (int)($_POST['sprint_id'] ?? 0);
$cumplida = isset($_POST['cumplida']) && $_POST['cumplida'] === '1';
$fecha_revision = date('Y-m-d');

if ($id <= 0 || $sprint_id <= 0) {
    header("Location: ../inicio.php?error=1");
    exit;
}

$controller = ControllersConfig::get_retro_controller();
$ok = $controller->evaluate_accion($id, $cumplida, $fecha_revision);

header("Location: ../retrospectiva.php?sprint_id=" . $sprint_id . "&cargar_anteriores=1" . ($ok ? "&ok=1" : "&error=1"));
exit;
