<?php
// Configuramos para que el navegador sepa que responderemos con JSON
header('Content-Type: application/json');

// Datos de conexión (Asegúrate que coincidan con tu Workbench)
require_once 'conexion.php';

try {

    // Leemos los datos que vienen del HTML (en formato JSON)
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validamos que no vengan vacíos
    $nombre = trim($data['nombre'] ?? '');
    $correo = trim($data['correo'] ?? '');
    $password = trim($data['password'] ?? '');
    $rol_id = $data['rol_id'] ?? '';

    if (empty($nombre) || empty($correo) || empty($password) || empty($rol_id)) {
        echo json_encode(['success' => false, 'mensaje' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // --- SEGURIDAD: Encriptamos la contraseña ---
    // Esto hace que en la base de datos no se vea la clave real, sino un código secreto
    $password_segura = password_hash($password, PASSWORD_DEFAULT);

    // Preparamos la consulta SQL para insertar
    $query = "INSERT INTO usuarios (NombreCompleto, Correo, Password, Rol_Id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    
    // Ejecutamos la jugada
    $stmt->execute([$nombre, $correo, $password_segura, $rol_id]);

    // Si todo sale bien, mandamos el éxito al HTML
    echo json_encode(['success' => true, 'mensaje' => '¡Usuario registrado correctamente!']);

} catch (PDOException $e) {
    // Si el correo ya existe, MySQL nos dará un error de duplicado (código 23000)
    if ($e->getCode() == 23000) {
        echo json_encode(['success' => false, 'mensaje' => 'El correo electrónico ya está registrado.']);
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.']);
    }
}
?>