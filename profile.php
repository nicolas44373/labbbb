<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo '<div class="alert error">Por favor, <a href="login.php">inicia sesión</a> para acceder a esta página.</div>';
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];

    $full_name = $conn->real_escape_string($full_name);
    $address = $conn->real_escape_string($address);
    $phone_number = $conn->real_escape_string($phone_number);

    $sql = "INSERT INTO profiles (user_id, full_name, address, phone_number) VALUES ('$user_id', '$full_name', '$address', '$phone_number')
            ON DUPLICATE KEY UPDATE full_name='$full_name', address='$address', phone_number='$phone_number'";

    if ($conn->query($sql) === TRUE) {
        $alert_message = 'Perfil actualizado con éxito.';
    } else {
        $alert_message = "Error: " . $conn->error;
    }
}

// Obtener perfil del usuario
$sql = "SELECT * FROM profiles WHERE user_id='$user_id'";
$result = $conn->query($sql);
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Perfil</h1>
            <nav>
                <a href="index.php">Página de Inicio</a> |
                <a href="create_post.php">Crear Publicación</a> |
                <a href="view_posts.php">Ver Publicaciones</a> |
                <a href="view_categories.php">Ver Categorías</a> |
                <a href="logout.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php if (isset($alert_message)): ?>
            <div class="alert success"><?php echo htmlspecialchars($alert_message); ?></div>
        <?php endif; ?>
        <form method="post" action="profile.php">
            <label for="full_name">Nombre Completo:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($profile['full_name'] ?? ''); ?>" />

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>" />

            <label for="phone_number">Teléfono:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($profile['phone_number'] ?? ''); ?>" />

            <button type="submit">Actualizar Perfil</button>
        </form>
        <br>
        <a href="index.php" class="btn-primary">Volver a la página principal</a>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Tu Nombre. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
