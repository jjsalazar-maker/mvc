<?php
require_once "../models/database/registro_db_interface.php";
require_once "../models/database/registro_db.php";
require_once "../models/entities/sprint.php";
require_once "../models/mappers/sprint_mappers.php";
require_once "../models/repositories/sprints_repository/sprint_repository_interface.php";
require_once "../models/repositories/sprints_repository/sprint_repository.php";
require_once "../models/config/models_config.php";
require_once "../controllers/mappers/sprints_mapper_controller.php";
require_once "../controllers/sprints/sprints_controller_interface.php";
require_once "../controllers/sprints/sprints_controller.php";
require_once "../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

function e($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

$titulo = "Nuevo sprint";
$action = "operaciones/registrar_sprint.php";
$id = 0;
$nombre = "";
$fecha_inicio = "";
$fecha_fin = "";

// Si se recibe un identificador por GET, conmuta el destino a edición y precarga los campos
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    $titulo = "Editar sprint";
    $action = "operaciones/modificar_sprint.php";

    try {
        $controller = ControllersConfig::get_sprints_controller();
        $sprint = $controller->get_sprint($id);
        $nombre = $sprint->get_nombre();
        $fecha_inicio = $sprint->get_fecha_inicio();
        $fecha_fin = $sprint->get_fecha_fin();
    } catch (Exception $ex) {
        header("Location: inicio.php?error=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?></title>
    <link rel="stylesheet" href="../public/css/estilos.css">
</head>

<body>
    <main class="contenedor">

        <div class="encabezado-pagina">
            <h1><?= e($titulo) ?></h1>
            <a class="btn btn--secundario" href="inicio.php">Volver</a>
        </div>
        <?php if (!empty($_GET['error'])) : ?>
            <p class="alerta alerta--error">
                <?= $_GET['error'] === 'fechas'
                    ? 'La fecha de fin no puede ser anterior a la de inicio.'
                    : 'Faltan datos o alguno no es válido.' ?>
            </p>
        <?php endif; ?>

        <form class="formulario" method="post" action="<?= e($action) ?>">
            <input type="hidden" name="id" value="<?= e($id) ?>">

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" maxlength="100" value="<?= e($nombre) ?>" required>
            </div>

            <div class="campo">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= e($fecha_inicio) ?>" required>
            </div>

            <div class="campo">
                <label for="fecha_fin">Fecha de fin</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?= e($fecha_fin) ?>" required>
            </div>

            <div class="formulario__botones">
                <button type="submit" class="btn btn--primario">Guardar</button>
                <a class="btn btn--secundario" href="inicio.php">Cancelar</a>
            </div>
        </form>

    </main>
</body>

</html>