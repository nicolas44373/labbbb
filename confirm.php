<?php
include 'db.php';

if (isset($_GET['code'])) {
    $confirmation_code = $conn->real_escape_string($_GET['code']);

    $sql = "UPDATE users SET confirmed = 1 WHERE confirmation_code = '$confirmation_code'";

    if ($conn->query($sql) === TRUE) {
        echo '¡Correo confirmado exitosamente!';
    } else {
        echo 'Error al confirmar el correo.';
    }
}
?>
