<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    if (!$id) {
        throw new Exception("No se proporcionó el ID del usuario.");
    }

    // Para evitar que se borren a ellos mismos por accidente (suponiendo que su id es 1 o están logueados)
    // Ojo: Esto es una medida de seguridad extra, pero por ahora permitiremos todo si tienen ID.
    if ($id == 1) {
        throw new Exception("No puedes eliminar al administrador principal del sistema.");
    }

    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE IdUsuario = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'mensaje' => 'Usuario eliminado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'mensaje' => 'No se encontró el usuario o ya fue eliminado.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => $e->getMessage()
    ]);
}
?>
