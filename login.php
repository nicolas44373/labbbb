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
                echo 'Inicio de sesión exitoso. <a href="index.php">Volver a la página principal</a>';
            } else {
                echo 'Por favor, confirma tu correo electrónico.';
            }
        } else {
            echo 'Contraseña incorrecta.';
        }
    } else {
        echo 'El correo electrónico no está registrado.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="post" action="login.php">
        <label>Correo Electrónico:</label>
        <input type="email" name="email" required />
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required />
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
