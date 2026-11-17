<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}
$nombre = trim($_POST['nombre'] ?? '');
$fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
$fecha_fin = trim($_POST['fecha_fin'] ?? '');

if ($nombre === '' || $fecha_inicio === '' || $fecha_fin === '') {
    header("Location: ../sprint_form.php?error=datos");
    exit;
}

if ($fecha_fin < $fecha_inicio) {
    header("Location: ../sprint_form.php?error=fechas");
    exit;
}
$ok = true;

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
