# Guía de Onboarding del Proyecto

Estamos haciendo un sistema web para administrar una liga de fut local. Lleva el control de equipos, jugadores, roles de juego, tablas de posiciones y todo el tema de pagos e inscripciones.

## El Stack (Con el que trabajamos)
Cero frameworks pesados, todo es muy directo:
- Front: HTML, CSS y JS puro (Vanilla).
- Back: PHP puro que usamos como si fuera una API.
- BD: MySQL.
- Entorno local: Docker o XAMPP.

## Cómo correrlo en tu laptop
Si usas Docker (te lo recomiendo para no batallar):
1. Abre tu terminal en la carpeta del proyecto.
2. Corre: docker-compose up -d
3. Entra a http://localhost:8080. La base de datos queda en el puerto 3307.

Si usas XAMPP:
1. Mete la carpeta del proyecto en htdocs.
2. Abre phpMyAdmin, crea una base de datos que se llame club_leon y córrerle el script init.sql a mano.

## Cómo fluye la información (Front y Back)
Acá la regla principal es que no mezclamos cosas. El front y el back están separados.
1. El usuario interactúa con la interfaz (el HTML).
2. La página detecta el clic o acción del usuario y le avisa al servidor en PHP mediante un fetch() en JS.
3. El PHP recibe los datos, se comunica con la base de datos de forma segura usando un conector estándar (PDO), ejecuta su lógica y nos regresa una respuesta en formato JSON.

## Reglas de desarrollo
Para mantener el código limpio y seguro, todos seguimos estas reglas:
1. Prevención de inyecciones SQL: Queda prohibida la concatenación directa de variables en las consultas. El estándar del proyecto es utilizar PDO con sentencias preparadas (prepare y execute).
2. Estándar de respuestas: Todo endpoint de PHP debe retornar siempre un JSON con esta estructura exacta: {"success": true/false, "mensaje": "..."}.
3. Seguridad de contraseñas: Las contraseñas no se almacenan en texto plano bajo ninguna circunstancia. Es obligatorio encriptarlas utilizando password_hash() y validarlas con password_verify().
4. Manejo de errores (Try-catch): Si un archivo PHP realiza una transacción o consulta compleja en la base de datos, debe ir dentro de un bloque try-catch. Así, si ocurre un error en el servidor, se puede devolver un mensaje de error controlado en el JSON evitando que la aplicación falle visualmente.

## Mapa Detallado del Proyecto: Para qué sirve cada archivo

A continuación, se detalla el uso exacto de cada directorio y archivo en el sistema para comprender la arquitectura completa:

### Carpetas Frontend
- `/css/`: Almacena exclusivamente las hojas de estilo del proyecto. Si modificas el diseño de una pantalla, debes hacerlo aquí.
- `/js/`: Contiene toda la lógica del cliente. Aquí viven los scripts que toman los datos de los formularios HTML, aplican validaciones visuales y disparan las peticiones asíncronas (fetch) hacia los endpoints de PHP.

### Archivos de Configuración e Infraestructura
- `conexion.php`: Es el script más importante del backend. Contiene las credenciales y el objeto PDO que abre la conexión a MySQL. Todos los demás endpoints deben requerir este archivo.
- `init.sql`: Contiene las consultas DDL (Data Definition Language) para crear la base de datos desde cero, junto con los datos de prueba.
- `Dockerfile` y `docker-compose.yml`: Archivos de orquestación que construyen el servidor Apache con PHP 8.2 y el motor MySQL en contenedores aislados.

### Módulo 1: Autenticación y Seguridad
Maneja el acceso, los logins y los cifrados.
- `login_futbolero.html`: Interfaz de inicio de sesión.
- `validar_login.php`: Recibe credenciales, busca el correo en la base de datos y verifica el hash de la contraseña.
- `verificar_sesion.php`: Script de validación que se incluye en las páginas protegidas para asegurar que el usuario tenga sesión activa.
- `cerrar_sesion.php`: Destruye las variables de sesión y redirige al login.

### Módulo 2: Panel de Administración
- `paginaS.html`: El Dashboard principal o menú de inicio una vez que el usuario ingresa al sistema.
- `menu-opciones.html`: Vista de navegación secundaria.

### Módulo 3: Equipos y Jugadores
Gestión del registro deportivo.
- Vistas: `registro-equipos.html`, `registro-jugadores.html`.
- Endpoints de creación: `guardar_equipo.php`, `guardar_jugador.php`.
- Endpoints de consulta: `obtener_equipos.php` (devuelve el catálogo de equipos).
- Endpoints de eliminación: `eliminar_equipo.php`.

### Módulo 4: Torneo, Partidos y Resultados
Administra el transcurso de la liga y la tabla de posiciones.
- Vistas de gestión: `agregar-partido.html`, `rol-juego.html`, `roles-juego-tabla.html`.
- Vistas de resultados: `cargar-resultados.html`, `tabla-posiciones.html`.
- Endpoints de guardado: `guardar_partido.php`, `guardar_resultado.php`.
- Endpoints de consulta: `obtener_partidos.php`, `obtener_partidos_pendientes.php`, `obtener_posiciones.php`.
- Endpoints de eliminación: `eliminar_partido.php`.

### Módulo 5: Finanzas e Ingresos
Control económico del club.
- Vistas: `pago-abonos.html`, `pago-arbitraje.html`, `pago-inscripcion.html`, `registro-pagos.html`.
- Endpoints de guardado: `guardar_abono.php`, `guardar_arbitraje.php`, `guardar_inscripcion.php`.

### Módulo 6: Administración de Usuarios (Staff)
Manejo de los administradores y encargados de la liga.
- Vistas: `agregar-usuario.html`, `gestionar-usuarios.html`.
- Endpoints de base de datos: `guardar_usuario.php`, `obtener_usuarios.php`, `eliminar_usuario.php`, `obtener_roles.php`.

## Guía Técnica: ¿Cómo crear un Endpoint nuevo?

Si el sistema necesita crecer y te asignan crear una nueva función (por ejemplo, "Actualizar un equipo"), debes seguir exactamente este flujo para no romper la arquitectura:

1. Crear el Archivo: Crea un archivo `.php` nuevo en la carpeta raíz, siguiendo la convención de nombres de acción (ej. `actualizar_equipo.php`).
2. Configurar la cabecera JSON: La primera línea de tu PHP debe ser `header('Content-Type: application/json');`.
3. Leer los datos del Frontend: Utiliza `$data = json_decode(file_get_contents('php://input'), true);` para atrapar lo que envió JavaScript.
4. Importar Conexión: Incluye obligatoriamente el archivo `require_once 'conexion.php';`.
5. Estructura Segura: Abre un bloque `try { ... } catch(Exception $e) { ... }`.
6. Consultas con PDO: Adentro del `try`, escribe tu query usando PDO. Por ejemplo: `$stmt = $pdo->prepare("UPDATE equipos SET nombre = ? WHERE id = ?"); $stmt->execute([$nombre, $id]);`.
7. Retornar Respuesta: Al finalizar la operación en el `try`, imprime el JSON de éxito: `echo json_encode(['success' => true, 'mensaje' => 'Equipo actualizado']);`. Si ocurre un error, en el `catch` debes retornar: `echo json_encode(['success' => false, 'mensaje' => 'Error en servidor']);`.
8. Conectar el Frontend: Finalmente, en tu archivo de JavaScript, programa un `fetch('actualizar_equipo.php', { method: 'POST', body: JSON.stringify(datos) })` para consumir tu nuevo endpoint.
