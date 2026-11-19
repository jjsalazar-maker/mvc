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

$controller = ControllersConfig::get_sprints_controller();
$sprints = $controller->get_sprints_all();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprints</title>
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
            <h2>Sprints</h2>
            <a class="btn btn--primario" href="sprint_form.php">+ Nuevo sprint</a>
        </div>

        <?php if (!empty($_GET['ok'])) : ?>
            <p class="alerta alerta--ok">Cambios guardados correctamente.</p>
        <?php endif; ?>
        <?php if (!empty($_GET['error'])) : ?>
            <p class="alerta alerta--error">No se pudo completar la operación.</p>
        <?php endif; ?>

        <?php if (empty($sprints)) : ?>
            <p class="vacio">Todavía no hay sprints. Crea el primero con el botón de arriba.</p>
        <?php else : ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sprints as $sprint) : ?>
                        <tr>
                            <td><?= e($sprint->get_id()) ?></td>
                            <td><?= e($sprint->get_nombre()) ?></td>
                            <td><?= e($sprint->get_fecha_inicio()) ?></td>
                            <td><?= e($sprint->get_fecha_fin()) ?></td>
                            <td>
                                <a class="btn btn--secundario btn--chico" href="retrospectiva.php?sprint_id=<?= e($sprint->get_id()) ?>">Ver retrospectiva</a>
                                <a class="btn btn--secundario btn--chico" href="sprint_form.php?id=<?= e($sprint->get_id()) ?>">Editar</a>

                                <form class="en-linea" method="post" action="operaciones/borrar_sprint.php">
                                    <input type="hidden" name="id" value="<?= e($sprint->get_id()) ?>">
                                    <button type="submit" class="btn btn--peligro btn--chico">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <footer>
        <p>Grupo 1</p>
    </footer>
</body>

</html>