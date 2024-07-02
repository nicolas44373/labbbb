<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Por favor, <a href="login.php">inicia sesión</a> para acceder a esta página.';
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
        echo 'Perfil actualizado con éxito.';
    } else {
        echo "Error: " . $conn->error;
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
</head>
<body>
    <h1>Perfil</h1>
    <form method="post" action="profile.php">
        <label>Nombre Completo:</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($profile['full_name'] ?? ''); ?>" />
        <br>
        <label>Dirección:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>" />
        <br>
        <label>Teléfono:</label>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($profile['phone_number'] ?? ''); ?>" />
        <br>
        <button type="submit">Actualizar Perfil</button>
    </form>
    <br>
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
