<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$usuarioInput = trim($data['usuario'] ?? '');
$passwordInput = trim($data['password'] ?? '');

// DIAGNÓSTICO 1: ¿El HTML nos mandó los datos vacíos?
if (empty($usuarioInput) || empty($passwordInput)) {
    echo json_encode(['success' => false, 'mensaje' => "ERROR: El PHP recibió datos en blanco. Revisa los IDs en el HTML."]);
    exit;
}

require_once 'conexion.php';

try {

    // Solo buscaremos por correo para evitar broncas con el ID numérico
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Correo = ?");
    $stmt->execute([$usuarioInput]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // DIAGNÓSTICO 2: ¿Encontró el correo en la base de datos?
    if (!$user) {
        echo json_encode(['success' => false, 'mensaje' => "ERROR: El correo '$usuarioInput' no existe en la base de datos."]);
        exit;
    }

    // DIAGNÓSTICO 3: ¿La contraseña es correcta?
    if (password_verify($passwordInput, $user['Password'])) {
        session_start();
        $_SESSION['usuario_id'] = $user['IdUsuario'];
        $_SESSION['usuario_correo'] = $user['Correo'];
        echo json_encode(['success' => true, 'mensaje' => '¡Ingreso exitoso!']);
    } else {
        echo json_encode(['success' => false, 'mensaje' => "ERROR: Contraseña incorrecta para el usuario " . $user['Correo']]);
    }

} catch(Exception $e) {
    echo json_encode(['success' => false, 'mensaje' => 'Ocurrió un error en el servidor. Intenta nuevamente.']);
}
?>