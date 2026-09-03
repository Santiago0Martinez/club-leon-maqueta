<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    // Consultamos los roles oficiales (Admin, Encargado del rol, Encargado de liga)
    $stmt = $pdo->prepare("SELECT IdRol, NombreRol FROM roles ORDER BY IdRol ASC");
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true, 
        'data' => $roles
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.'
    ]);
}
?>