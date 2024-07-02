<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $name = $conn->real_escape_string($name);

    $sql = "INSERT INTO categories (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert success">Categoría creada con éxito. <a href="view_categories.php">Ver Categorías</a> | <a href="index.php">Volver a la página principal</a></div>';
    } else {
        echo '<div class="alert error">Error: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Crear una Nueva Categoría</h1>
        <nav>
            <a href="index.php">Inicio</a> |
            <a href="view_posts.php">Ver Publicaciones</a> |
            <a href="view_categories.php">Ver Categorías</a> |
            <a href="profile.php">Ver/Editar Perfil</a> |
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main class="container">
        <form method="post" action="create_category.php">
            <label>Nombre de Categoría:</label>
            <input type="text" name="name" required />
            <br>
            <button type="submit">Crear Categoría</button>
        </form>
        <br>
        <a class="btn-secondary" href="view_categories.php">Ver Categorías</a> |
        <a class="btn-primary" href="index.php">Volver a la página principal</a>
    </main>
    <footer>
        <p>&copy; 2024 Tu Nombre. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
