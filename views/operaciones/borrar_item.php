<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$sprint_id = (int)($_POST['sprint_id'] ?? 0);

// cancela y redirige al listado general si falta el ID de la referencia
if ($id <= 0 || $sprint_id <= 0) {
    header("Location: ../inicio.php?error=1");
    exit;
}

$ok = true;

header("Location: ../retrospectiva.php?sprint_id=" . $sprint_id . ($ok ? "&ok=1" : "&error=1"));
exit;
