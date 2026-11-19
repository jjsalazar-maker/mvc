<?php
require_once "../models/database/registro_db_interface.php";
require_once "../models/database/registro_db.php";
require_once "../models/entities/sprint.php";
require_once "../models/entities/retro_items.php";
require_once "../models/mappers/sprint_mappers.php";
require_once "../models/mappers/retro_mappers.php";
require_once "../models/repositories/sprints_repository/sprint_repository_interface.php";
require_once "../models/repositories/sprints_repository/sprint_repository.php";
require_once "../models/repositories/sprints_repository/retro_repository_interface.php";
require_once "../models/repositories/sprints_repository/retro_repository.php";
require_once "../models/config/models_config.php";
require_once "../controllers/mappers/sprints_mapper_controller.php";
require_once "../controllers/mappers/retro_mapper_controller.php";
require_once "../controllers/sprints/sprints_controller_interface.php";
require_once "../controllers/sprints/sprints_controller.php";
require_once "../controllers/retro_items/retro_controller_interface.php";
require_once "../controllers/retro_items/retro_controller.php";
require_once "../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

function e($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

// Recupera el identificador del sprint desde la URL sii es inválido no existe redirige al inicio
$sprint_id = (int)($_GET['sprint_id'] ?? 0);
if ($sprint_id <= 0) {
    header("Location: inicio.php?error=1");
    exit;
}

try {
    $sprintsController = ControllersConfig::get_sprints_controller();
    $retroController = ControllersConfig::get_retro_controller();

    $sprint = $sprintsController->get_sprint($sprint_id);
    $items = $retroController->get_retros_by_sprint($sprint_id);
    $sprint_anterior = $sprintsController->get_previous_sprint($sprint_id);
    $acciones_anteriores = [];

    if ($sprint_anterior !== null && !empty($_GET['cargar_anteriores'])) {
        $acciones_anteriores = $retroController->get_acciones_by_sprint($sprint_anterior->get_id());
    }
} catch (Exception $ex) {
    header("Location: inicio.php?error=1");
    exit;
}

$grupos = ['logro' => [], 'impedimento' => [], 'accion' => [], 'otros' => []];
foreach ($items as $item) {
    $cat = $item->get_categoria();
    if (in_array($cat, ['logro', 'impedimento', 'accion'], true)) {
        $grupos[$cat][] = $item;
    } else {
        $grupos['otros'][] = $item;
    }
}

// Componente reutilizable que encapsula la estructura HTML de cada tarjeta de ítem
function tarjeta_item($item, $sprint_id)
{
?>
    <article class="item">
        <p class="item__texto"><?= nl2br(e($item->get_descripcion())) ?></p>

        <?php if ($item->get_categoria() === 'accion') : ?>
            <p class="item__meta">
                <?php if ($item->get_cumplida() === null) : ?>
                    <span class="insignia insignia--pendiente">Pendiente</span>
                <?php elseif ($item->get_cumplida()) : ?>
                    <span class="insignia insignia--ok">Cumplida</span>
                <?php else : ?>
                    <span class="insignia insignia--no">No cumplida</span>
                <?php endif; ?>
                <?php if ($item->get_fecha_revision()) : ?>
                    Revisión: <?= e($item->get_fecha_revision()) ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <div class="item__botones">
            <a class="btn btn--secundario btn--chico" href="item_form.php?id=<?= e($item->get_id()) ?>&amp;sprint_id=<?= e($sprint_id) ?>">Editar</a>
            <form class="en-linea" method="post" action="operaciones/borrar_item.php">
                <input type="hidden" name="id" value="<?= e($item->get_id()) ?>">
                <input type="hidden" name="sprint_id" value="<?= e($sprint_id) ?>">
                <button type="submit" class="btn btn--peligro btn--chico">Eliminar</button>
            </form>
        </div>
    </article>
<?php
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrospectiva · <?= e($sprint->get_nombre()) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/estilos.css">
</head>

<body>
    <header>
        <h1 class="animacion-entrada">REGISTRO DE RETROSPECTIVAS</h1>
        <p>Seguimiento de sprints, logros, impedimentos y acciones del equipo.</p>
    </header>

    <nav>
        <ul class="menu-flex">
            <li><a href="inicio.php">Sprints</a></li>
            <li><a href="sprint_form.php">Nuevo sprint</a></li>
        </ul>
    </nav>

    <main class="contenedor">

        <div class="encabezado-pagina">
            <h2>Retrospectiva: <?= e($sprint->get_nombre()) ?></h2>
            <div class="item__botones">
                <?php if ($sprint_anterior !== null) : ?>
                    <a class="btn btn--primario" href="retrospectiva.php?sprint_id=<?= e($sprint_id) ?>&amp;cargar_anteriores=1">
                        Cargar acciones de <?= e($sprint_anterior->get_nombre()) ?>
                    </a>
                <?php endif; ?>
                <a class="btn btn--secundario" href="inicio.php">Volver a sprints</a>
            </div>
        </div>

        <?php if (!empty($_GET['ok'])) : ?>
            <p class="alerta alerta--ok">Cambios guardados correctamente.</p>
        <?php endif; ?>
        <?php if (!empty($_GET['error'])) : ?>
            <p class="alerta alerta--error">No se pudo completar la operación.</p>
        <?php endif; ?>

        <?php if ($sprint_anterior !== null && !empty($_GET['cargar_anteriores'])) : ?>
            <div class="tarjeta tarjeta--accion">
                <div class="tarjeta__encabezado">
                    <h3>Seguimiento de Acciones · <?= e($sprint_anterior->get_nombre()) ?></h3>
                    <a class="btn btn--secundario btn--chico" href="retrospectiva.php?sprint_id=<?= e($sprint_id) ?>">Ocultar</a>
                </div>
                <?php if (empty($acciones_anteriores)) : ?>
                    <p class="vacio">El sprint anterior no tiene acciones registradas.</p>
                <?php else : ?>
                    <?php foreach ($acciones_anteriores as $accion_ant) : ?>
                        <article class="item">
                            <p class="item__texto"><?= nl2br(e($accion_ant->get_descripcion())) ?></p>
                            <p class="item__meta">
                                Estado actual:
                                <?php if ($accion_ant->get_cumplida() === null) : ?>
                                    <span class="insignia insignia--pendiente">Pendiente</span>
                                <?php elseif ($accion_ant->get_cumplida()) : ?>
                                    <span class="insignia insignia--ok">Cumplida</span>
                                <?php else : ?>
                                    <span class="insignia insignia--no">No cumplida</span>
                                <?php endif; ?>
                                <?php if ($accion_ant->get_fecha_revision()) : ?>
                                    · Revisada el: <?= e($accion_ant->get_fecha_revision()) ?>
                                <?php endif; ?>
                            </p>
                            <form class="en-linea" method="post" action="operaciones/evaluar_accion.php">
                                <input type="hidden" name="id" value="<?= e($accion_ant->get_id()) ?>">
                                <input type="hidden" name="sprint_id" value="<?= e($sprint_id) ?>">
                                <input type="hidden" name="cumplida" value="1">
                                <button type="submit" class="btn btn--primario btn--chico">Marcar Cumplida</button>
                            </form>
                            <form class="en-linea" method="post" action="operaciones/evaluar_accion.php">
                                <input type="hidden" name="id" value="<?= e($accion_ant->get_id()) ?>">
                                <input type="hidden" name="sprint_id" value="<?= e($sprint_id) ?>">
                                <input type="hidden" name="cumplida" value="0">
                                <button type="submit" class="btn btn--peligro btn--chico">Marcar No Cumplida</button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="columnas">

            <div class="tarjeta tarjeta--logro">
                <div class="tarjeta__encabezado">
                    <h3>Logros <span class="subtitulo">Positivos</span></h3>
                    <!-- Preselecciona la categoría en la URL para abrir el formulario de creación ya configurado -->
                    <a class="btn btn--secundario btn--chico" href="item_form.php?sprint_id=<?= e($sprint_id) ?>&amp;categoria=logro">+ Agregar</a>
                </div>
                <?php if (empty($grupos['logro'])) : ?>
                    <p class="vacio">Sin logros todavía.</p>
                <?php endif; ?>
                <?php foreach ($grupos['logro'] as $item) {
                    tarjeta_item($item, $sprint_id);
                } ?>
            </div>

            <div class="tarjeta tarjeta--impedimento">
                <div class="tarjeta__encabezado">
                    <h3>Impedimentos <span class="subtitulo">A mejorar</span></h3>
                    <a class="btn btn--secundario btn--chico" href="item_form.php?sprint_id=<?= e($sprint_id) ?>&amp;categoria=impedimento">+ Agregar</a>
                </div>
                <?php if (empty($grupos['impedimento'])) : ?>
                    <p class="vacio">Sin impedimentos todavía.</p>
                <?php endif; ?>
                <?php foreach ($grupos['impedimento'] as $item) {
                    tarjeta_item($item, $sprint_id);
                } ?>
            </div>

            <div class="tarjeta tarjeta--accion">
                <div class="tarjeta__encabezado">
                    <h3>Acciones <span class="subtitulo">Compromisos</span></h3>
                    <a class="btn btn--secundario btn--chico" href="item_form.php?sprint_id=<?= e($sprint_id) ?>&amp;categoria=accion">+ Agregar</a>
                </div>
                <?php if (empty($grupos['accion'])) : ?>
                    <p class="vacio">Sin acciones todavía.</p>
                <?php endif; ?>
                <?php foreach ($grupos['accion'] as $item) {
                    tarjeta_item($item, $sprint_id);
                } ?>
            </div>

        </div>

        <div class="tarjeta tarjeta--otros">
            <div class="tarjeta__encabezado">
                <h3>Comentarios y otros</h3>
                <a class="btn btn--secundario btn--chico" href="item_form.php?sprint_id=<?= e($sprint_id) ?>&amp;categoria=comentario">+ Agregar</a>
            </div>
            <?php if (empty($grupos['otros'])) : ?>
                <p class="vacio">Sin comentarios todavía.</p>
            <?php endif; ?>
            <?php foreach ($grupos['otros'] as $item) {
                tarjeta_item($item, $sprint_id);
            } ?>
        </div>

    </main>

    <footer>
        <p>Grupo 1</p>
    </footer>
</body>

</html>