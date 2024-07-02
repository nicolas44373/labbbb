<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $name = $conn->real_escape_string($name);

    $sql = "INSERT INTO categories (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        echo 'Categoría creada con éxito. <a href="view_categories.php">Ver Categorías</a> | <a href="index.php">Volver a la página principal</a>';
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Categoría</title>
</head>
<body>
    <h1>Crear una Nueva Categoría</h1>
    <form method="post" action="create_category.php">
        <label>Nombre de Categoría:</label>
        <input type="text" name="name" required />
        <br>
        <button type="submit">Crear Categoría</button>
    </form>
    <br>
    <a href="view_categories.php">Ver Categorías</a> |
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
