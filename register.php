<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    // Validaciones básicas
    if ($password !== $password_confirm) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    $confirmation_code = md5(uniqid(rand(), true));

    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $password_hashed = $conn->real_escape_string($password_hashed);
    $confirmation_code = $conn->real_escape_string($confirmation_code);

    $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
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

                $mail->setFrom('villabenjamin14@gmail.com', 'nicolas');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Confirma tu correo electrónico';
                $mail->Body    = "Haz clic en el siguiente enlace para confirmar tu correo: <a href='http://localhost/mi_proyecto/confirm.php?code=$confirmation_code'>Confirmar correo</a>";

                $mail->send();
                echo 'Se ha enviado un correo de confirmación.';
            } catch (Exception $e) {
                echo "No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="post" action="register.php">
        <label>Nombre de Usuario:</label>
        <input type="text" name="username" required />
        <br>
        <label>Correo Electrónico:</label>
        <input type="email" name="email" required />
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required />
        <br>
        <label>Confirmar Contraseña:</label>
        <input type="password" name="password_confirm" required />
        <br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
