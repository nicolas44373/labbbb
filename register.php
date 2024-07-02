<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Asegúrate de que esta línea esté presente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $confirmation_code = md5(uniqid(rand(), true));

    // Validación de datos
    if ($password !== $password_confirm) {
        echo '<div class="alert error">Las contraseñas no coinciden.</div>';
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el correo electrónico ya está registrado
    $email = $conn->real_escape_string($email);
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="alert error">El correo electrónico ya está registrado.</div>';
    } else {
        $sql = "INSERT INTO users (username, email, password, confirmation_code) VALUES ('$username', '$email', '$password_hashed', '$confirmation_code')";

        if ($conn->query($sql) === TRUE) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'villabenjamin14@gmail.com';  // Tu correo de Gmail
                $mail->Password = 'efye ndtd yzfw nizm';  // Contraseña de Aplicación generada
                $mail->SMTPSecure = 'tls';  // Usar 'tls' para el puerto 587
                $mail->Port = 587;  // Usar 587 para 'tls'

                $mail->setFrom('villabenjamin14@gmail.com', 'Tu Nombre');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Confirma tu correo electrónico';
                $mail->Body    = "Haz clic en el siguiente enlace para confirmar tu correo: <a href='http://localhost/mi_proyecto/confirm.php?code=$confirmation_code'>Confirmar correo</a>";

                $mail->SMTPDebug = 2;  // Habilitar modo de depuración
                $mail->send();
                echo '<div class="alert success">Se ha enviado un correo de confirmación.</div>';
            } catch (Exception $e) {
                echo "<div class='alert error'>No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            echo "<div class='alert error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
        <nav>
            <a href="index.php">Página de Inicio</a>
            <a href="login.php">Iniciar Sesión</a>
        </nav>
    </header>
    <main class="container">
        <form method="post" action="register.php">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required />

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required />

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required />

            <label for="password_confirm">Confirmar Contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm" required />

            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
    </main>
</body>
</html>
