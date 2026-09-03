<?php
header('Content-Type: application/json');

require_once 'conexion.php';

try {

    // Hacemos JOIN para traer el nombre del rol, no solo el número
    $query = "
        SELECT 
            u.IdUsuario, 
            u.NombreCompleto, 
            u.Correo, 
            r.NombreRol 
        FROM usuarios u
        JOIN roles r ON u.Rol_Id = r.IdRol
        ORDER BY u.IdUsuario DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $usuarios
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.'
    ]);
}
?>