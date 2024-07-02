<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Por favor, <a href="login.php">inicia sesión</a> para acceder a esta página.';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $body = $_POST["body"];
    $categories = $_POST["categories"];  // Un array de IDs de categoría

    $title = $conn->real_escape_string($title);
    $body = $conn->real_escape_string($body);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (user_id, title, body) VALUES ('$user_id', '$title', '$body')";

    if ($conn->query($sql) === TRUE) {
        $post_id = $conn->insert_id;

        foreach ($categories as $category_id) {
            $category_id = $conn->real_escape_string($category_id);
            $sql = "INSERT INTO post_categories (post_id, category_id) VALUES ('$post_id', '$category_id')";
            $conn->query($sql);
        }

        echo 'Publicación creada con éxito. <a href="index.php">Volver a la página principal</a>';
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener categorías
$categories_result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Publicación</title>
</head>
<body>
    <h1>Crear una Nueva Publicación</h1>
    <form method="post" action="create_post.php">
        <label>Título:</label>
        <input type="text" name="title" required />
        <br>
        <label>Contenido:</label>
        <textarea name="body" rows="5" required></textarea>
        <br>
        <label>Categorías:</label>
        <select name="categories[]" multiple required>
            <?php while ($row = $categories_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <button type="submit">Crear Publicación</button>
    </form>
    <br>
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
