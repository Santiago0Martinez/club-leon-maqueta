<?php
// conexion.php
// Este archivo maneja la conexión a la base de datos centralizada.
// Si hay un error, lo captura y devuelve un JSON para no romper el frontend.

$host = getenv('DB_HOST') ?: '127.0.0.1';
$dbname = getenv('DB_NAME') ?: 'club_leon';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'admin'; // Contraseña de tu entorno local (Workbench)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la conexión falla, devolvemos un error en formato JSON y detenemos la ejecución
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false, 
        'mensaje' => 'Error de conexión a la base de datos. Intenta más tarde.'
    ]);
    exit;
}
?>
