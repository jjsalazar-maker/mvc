<?php
function e($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

// Por defecto: modo CREAR (campos vacíos)
$titulo = "Nuevo sprint";
$action = "operaciones/registrar_sprint.php";
$id = 0;
$nombre = "";
$fecha_inicio = "";
$fecha_fin = "";

// Si la URL trae ?id=..., entonces es modo EDITAR
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    $titulo = "Editar sprint";
    $action = "operaciones/modificar_sprint.php";

    // DATOS DE PRUEBA: luego los pide el controller con get_sprint($id)
    $nombre = "Sprint " . $id;
    $fecha_inicio = "2026-11-01";
    $fecha_fin = "2026-11-15";
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