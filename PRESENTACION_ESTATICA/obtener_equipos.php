<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    $stmt = $pdo->query("SELECT IdEquipo, Equipo FROM Equipos ORDER BY Equipo ASC");
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $equipos]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.']);
}
?>