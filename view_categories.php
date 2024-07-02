<?php
include 'db.php';

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Categorías</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Categorías</h1>
        <nav>
            <a href="index.php">Inicio</a> |
            <a href="profile.php">Ver/Editar Perfil</a> |
            <a href="create_post.php">Crear Publicación</a> |
            <a href="view_posts.php">Ver Publicaciones</a> |
            <a href="view_categories.php">Ver Categorías</a> |
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main class="container">
        <?php if ($result->num_rows > 0): ?>
            <ul class="category-list">
                <?php while($row = $result->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['name']); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay categorías disponibles.</p>
        <?php endif; ?>
        <br>
        <a class="btn-primary" href="create_category.php">Crear Categoría</a> |
        <a class="btn-secondary" href="index.php">Volver a la página principal</a>
    </main>
    <footer>
        <p>&copy; 2024 Tu Nombre. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
