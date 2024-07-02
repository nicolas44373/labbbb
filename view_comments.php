<?php
include 'db.php';

if (!isset($_GET['post_id'])) {
    echo '<div class="alert error">No se proporcionó un ID de publicación.</div>';
    exit();
}

$post_id = intval($_GET['post_id']);

$sql = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id='$post_id' ORDER BY comments.created_at DESC";
$result = $conn->query($sql);

$post_result = $conn->query("SELECT * FROM posts WHERE id='$post_id'");
$post = $post_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comentarios</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Comentarios para: <?php echo htmlspecialchars($post['title']); ?></h1>
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
            <ul class="comment-list">
                <?php while($row = $result->fetch_assoc()): ?>
                    <li class="comment-item">
                        <p><?php echo htmlspecialchars($row['comment']); ?></p>
                        <small>Comentado por <?php echo htmlspecialchars($row['username']); ?> en <?php echo $row['created_at']; ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay comentarios para esta publicación.</p>
        <?php endif; ?>
        <br>
        <a class="btn-primary" href="add_comment.php?post_id=<?php echo $post_id; ?>">Agregar Comentario</a> |
        <a class="btn-secondary" href="index.php">Volver a la página principal</a>
    </main>
    <footer>
        <p>&copy; 2024 Tu Nombre. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
