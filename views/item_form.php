<?php
function e($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

// Mapa de claves internas para base de datos yetiquetas visibles
$categorias = [
    'logro'       => 'Logro',
    'impedimento' => 'Impedimento',
    'accion'      => 'Acción',
    'comentario'  => 'Comentario',
    'otro'        => 'Otro',
];

$id = (int)($_GET['id'] ?? 0);
$sprint_id = (int)($_GET['sprint_id'] ?? 0);
$categoria = $_GET['categoria'] ?? 'logro';
if (!isset($categorias[$categoria])) {
    $categoria = 'logro';   // Restablece a un valor seguro si la clave no existe en la lista 
}

// Configuración inicial para insercion
$titulo = "Nuevo ítem";
$action = "operaciones/registrar_item.php";
$descripcion = "";
$cumplida = "";
$fecha_revision = "";

// Sobrescribe destino y precarga valores si se recibe un identificador existente
if ($id > 0) {
    $titulo = "Editar ítem";
    $action = "operaciones/modificar_item.php";

    // Valores simulados; en producción se reemplazan por la consulta real del registro
    $sprint_id = 1;
    $categoria = "accion";
    $descripcion = "Hacer reuniones diarias de 15 minutos";
    $cumplida = "";
    $fecha_revision = "";
}

// Bloquea el acceso y redirige si no hay un sprint asociado válido
if ($sprint_id <= 0) {
    header("Location: inicio.php?error=1");
    exit;
}

$volver = "retrospectiva.php?sprint_id=" . $sprint_id;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?></title>
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
            <h2><?= e($titulo) ?></h2>
            <a class="btn btn--secundario" href="<?= e($volver) ?>">Volver a la retrospectiva</a>
        </div>

        <?php if (!empty($_GET['error'])) : ?>
            <p class="alerta alerta--error">Faltan datos o alguno no es válido.</p>
        <?php endif; ?>

        <!-- Envía los identificadores ocultos para conservar el contexto en el procesamiento POST -->
        <form class="formulario" method="post" action="<?= e($action) ?>">
            <input type="hidden" name="id" value="<?= e($id) ?>">
            <input type="hidden" name="sprint_id" value="<?= e($sprint_id) ?>">
            <input type="hidden" name="cumplida" value="<?= e($cumplida) ?>">

            <div class="campo">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <?php foreach ($categorias as $valor => $texto) : ?>
                        <!-- Marca automáticamente la opción que coincide con la categoría activa -->
                        <option value="<?= e($valor) ?>" <?= $valor === $categoria ? 'selected' : '' ?>>
                            <?= e($texto) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="5" required><?= e($descripcion) ?></textarea>
            </div>

            <div class="campo">
                <label for="fecha_revision">
                    Fecha de revisión <span class="campo__ayuda">(opcional, útil para acciones)</span>
                </label>
                <input type="date" id="fecha_revision" name="fecha_revision" value="<?= e($fecha_revision) ?>">
            </div>

            <div class="formulario__botones">
                <button type="submit" class="btn btn--primario">Guardar</button>
                <a class="btn btn--secundario" href="<?= e($volver) ?>">Cancelar</a>
            </div>
        </form>

    </main>

    <footer>
        <p>&copy; 2026 - Registro de Retrospectivas</p>
    </footer>
</body>

</html>