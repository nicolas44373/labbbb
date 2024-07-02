<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $email = $conn->real_escape_string($email);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['confirmed'] == 1) {
                // Iniciar sesión
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $alert_message = 'Por favor, confirma tu correo electrónico.';
            }
        } else {
            $alert_message = 'Contraseña incorrecta.';
        }
    } else {
        $alert_message = 'El correo electrónico no está registrado.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Iniciar Sesión</h1>
            <nav>
                <a href="index.php">Página de Inicio</a>
                <a href="register.php">Registro</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <form method="post" action="login.php">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required />

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if (isset($alert_message)): ?>
            <div class="alert error"><?php echo htmlspecialchars($alert_message); ?></div>
        <?php endif; ?>
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> blog mundial. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
