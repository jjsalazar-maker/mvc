<?php
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

// Datos simulados para desarrollo; en producción provendrán de consultas a la base de datos
$sprint = ['id' => $sprint_id, 'nombre' => 'Sprint ' . $sprint_id];
$items = [
    ['id' => 1, 'categoria' => 'logro',       'descripcion' => 'Terminamos el módulo de login a tiempo', 'cumplida' => null, 'fecha_revision' => null],
    ['id' => 2, 'categoria' => 'logro',       'descripcion' => 'Buena comunicación en el equipo',        'cumplida' => null, 'fecha_revision' => null],
    ['id' => 3, 'categoria' => 'impedimento', 'descripcion' => 'El servidor de pruebas se cayó dos veces', 'cumplida' => null, 'fecha_revision' => null],
    ['id' => 4, 'categoria' => 'accion',      'descripcion' => 'Hacer reuniones diarias de 15 minutos',  'cumplida' => true, 'fecha_revision' => '2026-11-14'],
    ['id' => 5, 'categoria' => 'accion',      'descripcion' => 'Documentar los endpoints',               'cumplida' => null, 'fecha_revision' => null],
    ['id' => 6, 'categoria' => 'comentario',  'descripcion' => 'Revisar la carga de trabajo del próximo sprint', 'cumplida' => null, 'fecha_revision' => null],
];

// Clasifica la lista plana de ítems en cuatro contenedores para renderizar cada columna por separado
$grupos = ['logro' => [], 'impedimento' => [], 'accion' => [], 'otros' => []];
foreach ($items as $item) {
    if (in_array($item['categoria'], ['logro', 'impedimento', 'accion'], true)) {
        $grupos[$item['categoria']][] = $item;
    } else {
        $grupos['otros'][] = $item;   // concatena 
    }
}

// Componente reutilizable que encapsula la estructura HTML de cada tarjeta de ítem
function tarjeta_item($item, $sprint_id)
{
?>
    <article class="item">
        <!-- Escapa el contenido primero y luego convierte saltos de línea en etiquetas <br> -->
        <p class="item__texto"><?= nl2br(e($item['descripcion'])) ?></p>

        <!-- Muestra estado de cumplimiento y fecha límite únicamente si el ítem es de tipo acción -->
        <?php if ($item['categoria'] === 'accion') : ?>
            <p class="item__meta">
                <?php if ($item['cumplida'] === null) : ?>
                    <span class="insignia insignia--pendiente">Pendiente</span>
                <?php elseif ($item['cumplida']) : ?>
                    <span class="insignia insignia--ok">Cumplida</span>
                <?php else : ?>
                    <span class="insignia insignia--no">No cumplida</span>
                <?php endif; ?>
                <?php if ($item['fecha_revision']) : ?>
                    Revisión: <?= e($item['fecha_revision']) ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <div class="item__botones">
            <a class="btn btn--secundario btn--chico" href="item_form.php?id=<?= e($item['id']) ?>&amp;sprint_id=<?= e($sprint_id) ?>">Editar</a>
            <!-- Usa un formulario POST independiente para evitar borrados accidentales mediante enlaces GET -->
            <form class="en-linea" method="post" action="operaciones/borrar_item.php">
                <input type="hidden" name="id" value="<?= e($item['id']) ?>">
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
    <title>Retrospectiva · <?= e($sprint['nombre']) ?></title>
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
            <h2>Retrospectiva: <?= e($sprint['nombre']) ?></h2>
            <a class="btn btn--secundario" href="inicio.php">Volver a sprints</a>
        </div>

        <?php if (!empty($_GET['ok'])) : ?>
            <p class="alerta alerta--ok">Cambios guardados correctamente.</p>
        <?php endif; ?>
        <?php if (!empty($_GET['error'])) : ?>
            <p class="alerta alerta--error">No se pudo completar la operación.</p>
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