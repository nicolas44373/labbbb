<?php
include 'db.php';

if (!isset($_GET['post_id'])) {
    echo 'No se proporcionó un ID de publicación.';
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
</head>
<body>
    <h1>Comentarios para: <?php echo htmlspecialchars($post['title']); ?></h1>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li>
                    <p><?php echo htmlspecialchars($row['comment']); ?></p>
                    <small>Comentado por <?php echo htmlspecialchars($row['username']); ?> en <?php echo $row['created_at']; ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No hay comentarios para esta publicación.</p>
    <?php endif; ?>
    <br>
    <a href="add_comment.php?post_id=<?php echo $post_id; ?>">Agregar Comentario</a> |
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
