<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    // Solo traer partidos que NO estén en la tabla de posiciones
    $query = "
        SELECT 
            r.IdPartido,
            e1.Equipo AS Local,
            e2.Equipo AS Visitante
        FROM rol_juegos r
        JOIN equipos e1 ON r.EquipoLocal_Id = e1.IdEquipo
        JOIN equipos e2 ON r.EquipoVisitante_Id = e2.IdEquipo
        WHERE r.IdPartido NOT IN (SELECT `Rol de Juego_IdRol` FROM `tabla de posiciones`)
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $partidos]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.']);
}
?>