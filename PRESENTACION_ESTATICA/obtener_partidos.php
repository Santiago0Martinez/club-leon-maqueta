<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    // Hacemos JOIN con la tabla equipos dos veces (una para el local y otra para el visitante)
    // OJO: Asumo que tu tabla de equipos se llama "equipos". Si se llama distinto, cámbialo aquí.
    $query = "
        SELECT 
            r.IdPartido,
            e1.Equipo AS EquipoLocal,
            e2.Equipo AS EquipoVisitante,
            r.Fecha,
            r.Hora,
            r.Cancha
        FROM rol_juegos r
        JOIN equipos e1 ON r.EquipoLocal_Id = e1.IdEquipo
        JOIN equipos e2 ON r.EquipoVisitante_Id = e2.IdEquipo
        ORDER BY r.Fecha ASC, r.Hora ASC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $partidos
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.'
    ]);
}
?>