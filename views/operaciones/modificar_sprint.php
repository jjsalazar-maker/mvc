<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
$fecha_fin = trim($_POST['fecha_fin'] ?? '');

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

// SIMULADO: luego -> ->update_sprint($_POST)
$ok = true;

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
