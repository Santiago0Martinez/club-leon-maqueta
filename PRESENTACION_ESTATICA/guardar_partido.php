<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    $data = json_decode(file_get_contents('php://input'), true);

    $equipo_local = trim($data['equipo_local'] ?? '');
    $equipo_visitante = trim($data['equipo_visitante'] ?? '');
    $fecha = trim($data['fecha'] ?? '');
    $hora = trim($data['hora'] ?? '');
    $cancha = trim($data['cancha'] ?? '');

    // Validar que no falten datos
    if (empty($equipo_local) || empty($equipo_visitante) || empty($fecha) || empty($hora) || empty($cancha)) {
        throw new Exception("Todos los campos son obligatorios para programar el partido.");
    }

    // El VAR: Validar que un equipo no juegue contra sí mismo
    if ($equipo_local === $equipo_visitante) {
        throw new Exception("Un equipo no puede jugar contra sí mismo. Revisa la selección.");
    }

    $stmt = $pdo->prepare("INSERT INTO `rol_juegos` (EquipoLocal_Id, EquipoVisitante_Id, Fecha, Hora, Cancha) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$equipo_local, $equipo_visitante, $fecha, $hora, $cancha]);

    echo json_encode([
        'success' => true,
        'mensaje' => '¡Partido programado con éxito!'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.'
    ]);
}
?>