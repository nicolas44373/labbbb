<?php
include 'db.php';

$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Publicaciones</title>
</head>
<body>
    <h1>Publicaciones</h1>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['body']); ?></p>
                    <small>Publicado por <?php echo htmlspecialchars($row['username']); ?> en <?php echo $row['created_at']; ?></small>
                    <a href="view_comments.php?post_id=<?php echo $row['id']; ?>">Ver Comentarios</a> |
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
                        <a href="add_comment.php?post_id=<?php echo $row['id']; ?>">Agregar Comentario</a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No hay publicaciones disponibles.</p>
    <?php endif; ?>
    <br>
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
