<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../inicio.php");
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header("Location: ../inicio.php?error=1");
    exit;
}

// SIMULADO: luego -> ->delete_sprint($id)
$ok = true;

header("Location: ../inicio.php" . ($ok ? "?ok=1" : "?error=1"));
exit;
