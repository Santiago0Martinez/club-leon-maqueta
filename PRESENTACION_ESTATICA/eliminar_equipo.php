<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    if (!$id) {
        throw new Exception("No se proporcionó el ID del equipo.");
    }

    // Iniciar transacción para borrado en cascada
    $pdo->beginTransaction();

    // 1. Obtener IDs de los jugadores del equipo
    $stmtJugadores = $pdo->prepare("SELECT IdJugador FROM jugadores WHERE IdEquipo = ?");
    $stmtJugadores->execute([$id]);
    $jugadores = $stmtJugadores->fetchAll(PDO::FETCH_COLUMN);

    if (count($jugadores) > 0) {
        // 2. Eliminar pagos de esos jugadores (Registro de Pagos)
        $inQuery = implode(',', array_fill(0, count($jugadores), '?'));
        $stmtPagos = $pdo->prepare("DELETE FROM `Registro de Pagos` WHERE Jugadores_IdJugador IN ($inQuery)");
        $stmtPagos->execute($jugadores);
        
        // 3. Eliminar jugadores
        $stmtDelJugadores = $pdo->prepare("DELETE FROM jugadores WHERE IdEquipo = ?");
        $stmtDelJugadores->execute([$id]);
    }

    // 4. Eliminar tabla de posiciones
    $stmtPosiciones = $pdo->prepare("DELETE FROM `tabla de posiciones` WHERE `Rol de Juego_Equipos_IdEquipo` = ?");
    $stmtPosiciones->execute([$id]);

    // 5. Eliminar partidos programados (rol_juegos)
    $stmtRol = $pdo->prepare("DELETE FROM rol_juegos WHERE EquipoLocal_Id = ? OR EquipoVisitante_Id = ?");
    $stmtRol->execute([$id, $id]);

    // 6. Eliminar el equipo
    $stmtEquipo = $pdo->prepare("DELETE FROM equipos WHERE IdEquipo = ?");
    $stmtEquipo->execute([$id]);

    // Confirmar transacción
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'mensaje' => 'Equipo y todos sus registros relacionados eliminados exitosamente.'
    ]);

} catch (Exception $e) {
    // Revertir si hay error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error al eliminar equipo: ' . $e->getMessage()
    ]);
}
?>
