<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

$categorias_validas = ['logro', 'impedimento', 'accion', 'comentario', 'otro'];

$sprint_id = (int)($_POST['sprint_id'] ?? 0);
$categoria = $_POST['categoria'] ?? '';
$descripcion = trim($_POST['descripcion'] ?? '');
$fecha_revision = trim($_POST['fecha_revision'] ?? '');

// cancela y redirige al inicio si falta la referencia de un sprint válido
if ($sprint_id <= 0) {
    header("Location: ../inicio.php?error=1");
    exit;
}

// Verifica estrictamente que la categoría exista en la lista y que la descripción no llegue vacía
if (!in_array($categoria, $categorias_validas, true) || $descripcion === '') {
    header("Location: ../item_form.php?sprint_id=" . $sprint_id . "&error=datos");
    exit;
}

// Valida que las fechas sean en un formato dd/mm/año
if ($fecha_revision !== '') {
    $fecha = DateTime::createFromFormat('Y-m-d', $fecha_revision);
    if (!$fecha || $fecha->format('Y-m-d') !== $fecha_revision) {
        header("Location: ../item_form.php?sprint_id=" . $sprint_id . "&error=datos");
        exit;
    }
}

$ok = true;

header("Location: ../retrospectiva.php?sprint_id=" . $sprint_id . ($ok ? "&ok=1" : "&error=1"));
exit;
