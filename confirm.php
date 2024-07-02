<?php
include 'db.php';

if (isset($_GET['code'])) {
    $confirmation_code = $conn->real_escape_string($_GET['code']);

    $sql = "SELECT * FROM users WHERE confirmation_code='$confirmation_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['confirmed'] == 0) {
            $update_sql = "UPDATE users SET confirmed=1 WHERE confirmation_code='$confirmation_code'";
            if ($conn->query($update_sql) === TRUE) {
                echo 'Correo confirmado exitosamente. <a href="login.php">Inicia sesión</a>';
            } else {
                echo "Error al actualizar la confirmación.";
            }
        } else {
            echo 'El correo ya está confirmado.';
        }
    } else {
        echo 'Código de confirmación inválido.';
    }
} else {
    echo 'No se proporcionó un código de confirmación.';
}
?>
