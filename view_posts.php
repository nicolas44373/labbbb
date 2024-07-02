<?php
session_start();
include 'db.php';

$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Publicaciones</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Ver Publicaciones</h1>
        <nav>
            <a href="index.php">Inicio</a> |
            <a href="profile.php">Ver/Editar Perfil</a> |
            <a href="create_post.php">Crear Publicación</a> |
            <a href="view_categories.php">Ver Categorías</a> |
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main class="container">
        <?php if ($result->num_rows > 0): ?>
            <ul class="post-list">
                <?php while($row = $result->fetch_assoc()): ?>
                    <li class="post-item">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo htmlspecialchars($row['body']); ?></p>
                        <small>Publicado por <?php echo htmlspecialchars($row['username']); ?> en <?php echo $row['created_at']; ?></small>
                        <div class="post-actions">
                            <a class="btn-primary" href="view_comments.php?post_id=<?php echo $row['id']; ?>">Ver Comentarios</a>
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
                                <a class="btn-secondary" href="add_comment.php?post_id=<?php echo $row['id']; ?>">Agregar Comentario</a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay publicaciones disponibles.</p>
        <?php endif; ?>
        <br>
        <a class="btn-secondary" href="index.php">Volver a la página principal</a>
    </main>
    <footer>
        <p>&copy; 2024 Tu Nombre. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
