<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    if (!$id) {
        throw new Exception("No se proporcionó el ID del partido.");
    }

    $stmt = $pdo->prepare("DELETE FROM rol_juegos WHERE IdPartido = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'mensaje' => 'Partido eliminado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'mensaje' => 'No se encontró el partido o ya fue eliminado.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error al intentar eliminar el partido.'
    ]);
}
?>
