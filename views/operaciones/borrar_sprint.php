<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

// Extrae y convierte el identificador a enter
$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header("Location: ../inicio.php?error=1");
    exit;
}

$ok = true;

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
