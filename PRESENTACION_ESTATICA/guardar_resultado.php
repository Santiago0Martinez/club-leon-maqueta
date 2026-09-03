<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    $data = json_decode(file_get_contents('php://input'), true);

    $id_partido = $data['id_partido'] ?? '';
    $goles_local = $data['goles_local'] ?? '';
    $goles_visitante = $data['goles_visitante'] ?? '';

    if (empty($id_partido) || $goles_local === '' || $goles_visitante === '') {
        throw new Exception("Faltan datos para registrar el resultado.");
    }

    // 1. Obtener IDs de los equipos de ese partido
    $stmtPartido = $pdo->prepare("SELECT EquipoLocal_Id, EquipoVisitante_Id FROM rol_juegos WHERE IdPartido = ?");
    $stmtPartido->execute([$id_partido]);
    $partido = $stmtPartido->fetch(PDO::FETCH_ASSOC);

    $id_local = $partido['EquipoLocal_Id'];
    $id_visitante = $partido['EquipoVisitante_Id'];

    // 2. Calcular estatus inteligentemente
    $estatus_local = 'EMPATE';
    $estatus_visitante = 'EMPATE';

    if ($goles_local > $goles_visitante) {
        $estatus_local = 'VICTORIA';
        $estatus_visitante = 'DERROTA';
    } elseif ($goles_local < $goles_visitante) {
        $estatus_local = 'DERROTA';
        $estatus_visitante = 'VICTORIA';
    }

    // 3. Insertar resultado del LOCAL
    $stmtLocal = $pdo->prepare("INSERT INTO `tabla de posiciones` (`Rol de Juego_Equipos_IdEquipo`, `Rol de Juego_IdRol`, GolesAFavor, GolesEnContra, Estatus) VALUES (?, ?, ?, ?, ?)");
    $stmtLocal->execute([$id_local, $id_partido, $goles_local, $goles_visitante, $estatus_local]);

    // 4. Insertar resultado del VISITANTE
    $stmtVisitante = $pdo->prepare("INSERT INTO `tabla de posiciones` (`Rol de Juego_Equipos_IdEquipo`, `Rol de Juego_IdRol`, GolesAFavor, GolesEnContra, Estatus) VALUES (?, ?, ?, ?, ?)");
    $stmtVisitante->execute([$id_visitante, $id_partido, $goles_visitante, $goles_local, $estatus_visitante]);

    echo json_encode(['success' => true, 'mensaje' => '¡Marcador oficial registrado!']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.']);
}
?>