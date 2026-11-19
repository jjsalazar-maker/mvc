<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

// Extrae los campos del formulario asignando cadenas vacías por defecto y limpiando espacios laterales
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

$ok = true;

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
