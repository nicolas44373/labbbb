<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Por favor, <a href="login.php">inicia sesión</a> para acceder a esta página.';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];
    $categories = $_POST["categories"];  // Un array de IDs de categoría

    $post_id = $conn->real_escape_string($post_id);

    // Eliminar categorías existentes
    $sql = "DELETE FROM post_categories WHERE post_id='$post_id'";
    $conn->query($sql);

    foreach ($categories as $category_id) {
        $category_id = $conn->real_escape_string($category_id);
        $sql = "INSERT INTO post_categories (post_id, category_id) VALUES ('$post_id', '$category_id')";
        $conn->query($sql);
    }

    echo 'Categorías asignadas con éxito. <a href="index.php">Volver a la página principal</a>';
} else if (isset($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);

    // Obtener categorías
    $categories_result = $conn->query("SELECT * FROM categories");

    // Obtener categorías asignadas a la publicación
    $assigned_categories_result = $conn->query("SELECT category_id FROM post_categories WHERE post_id='$post_id'");
    $assigned_categories = [];
    while ($row = $assigned_categories_result->fetch_assoc()) {
        $assigned_categories[] = $row['category_id'];
    }
} else {
    echo 'No se proporcionó un ID de publicación.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Categorías</title>
</head>
<body>
    <h1>Asignar Categorías a una Publicación</h1>
    <form method="post" action="assign_category.php">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
        <label>Categorías:</label>
        <select name="categories[]" multiple required>
            <?php while ($row = $categories_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo in_array($row['id'], $assigned_categories) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br>
        <button type="submit">Asignar Categorías</button>
    </form>
    <br>
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
