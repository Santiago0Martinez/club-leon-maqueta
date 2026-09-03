<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    // Consulta nivel Dios: Calcula PJ, V, E, D y Puntos usando tus columnas de goles
    $query = "
        SELECT 
            e.Equipo,
            COUNT(tp.IdPosicion) AS PJ,
            SUM(CASE WHEN tp.GolesAFavor > tp.GolesEnContra THEN 1 ELSE 0 END) AS V,
            SUM(CASE WHEN tp.GolesAFavor = tp.GolesEnContra THEN 1 ELSE 0 END) AS E,
            SUM(CASE WHEN tp.GolesAFavor < tp.GolesEnContra THEN 1 ELSE 0 END) AS D,
            SUM(
                CASE WHEN tp.GolesAFavor > tp.GolesEnContra THEN 3
                     WHEN tp.GolesAFavor = tp.GolesEnContra THEN 1
                     ELSE 0 END
            ) AS PTS,
            SUM(tp.GolesAFavor) AS GolesAFavor,
            SUM(tp.GolesEnContra) AS GolesEnContra
        FROM `tabla de posiciones` tp
        JOIN `equipos` e ON tp.`Rol de Juego_Equipos_IdEquipo` = e.IdEquipo
        GROUP BY e.IdEquipo, e.Equipo
        ORDER BY PTS DESC, (SUM(tp.GolesAFavor) - SUM(tp.GolesEnContra)) DESC, GolesAFavor DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $posiciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $posiciones
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.'
    ]);
}
?>