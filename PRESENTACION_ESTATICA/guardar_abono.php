<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    $data = json_decode(file_get_contents('php://input'), true);

    // Recibimos los datos del frontend
    $equipo_id = trim($data['equipo_id'] ?? '');
    $monto = trim($data['monto'] ?? '');
    $parcialidad = trim($data['parcialidad'] ?? '');
    $fecha = trim($data['fecha'] ?? '');

    if (empty($equipo_id) || empty($monto) || empty($parcialidad) || empty($fecha)) {
        throw new Exception("Faltan datos para registrar el abono.");
    }

    // Como tu tabla pide "Usuario_IdUsuario", usaremos el ID 1 temporalmente 
    // para cumplir con la llave foránea de tu base de datos.
    $id_usuario = 1; 

    // Insertamos usando TUS nombres de columnas exactos
    $stmt = $pdo->prepare("INSERT INTO `registro de abono` (Usuario_IdUsuario, MontoAbonado, Parcialidad, FechaDeAbono) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $monto, $parcialidad, $fecha]);

    echo json_encode([
        'success' => true,
        'mensaje' => 'Abono registrado correctamente.'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.'
    ]);
}
?>