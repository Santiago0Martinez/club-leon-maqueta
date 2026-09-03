<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'logged_in' => true,
        'usuario_correo' => $_SESSION['usuario_correo']
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>
