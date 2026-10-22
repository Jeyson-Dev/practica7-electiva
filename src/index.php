<?php
// Datos de conexion tomados de las variables de entorno definidas en docker-compose.yml
$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'holamundo';
$user = getenv('DB_USER') ?: 'app';
$pass = getenv('DB_PASSWORD') ?: 'app123';

$mensajes = [];
$error = null;
$version = null;

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    $mensajes = $pdo->query('SELECT id, texto, creado_en FROM mensajes ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hola Mundo - PHP + MySQL</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
        .ok { color: #1a7f37; }
        .error { color: #cf222e; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>¡Hola Mundo!</h1>
    <p>Aplicación PHP <?= PHP_VERSION ?> ejecutándose en Docker.</p>

    <?php if ($error): ?>
        <p class="error"><strong>Error al conectar a MySQL:</strong> <?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <p class="ok"><strong>Conexión exitosa</strong> a MySQL <?= htmlspecialchars($version) ?> (host: <?= htmlspecialchars($host) ?>, bd: <?= htmlspecialchars($db) ?>)</p>

        <h2>Mensajes desde la base de datos</h2>
        <table>
            <tr><th>ID</th><th>Texto</th><th>Creado en</th></tr>
            <?php foreach ($mensajes as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><?= htmlspecialchars($m['texto']) ?></td>
                    <td><?= $m['creado_en'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
