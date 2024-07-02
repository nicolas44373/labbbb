<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Por favor, <a href="login.php">inicia sesión</a> para acceder a esta página.';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];
    $comment = $_POST["comment"];

    $post_id = $conn->real_escape_string($post_id);
    $comment = $conn->real_escape_string($comment);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert success">Comentario agregado con éxito. <a href="view_comments.php?post_id=' . $post_id . '">Ver Comentarios</a> | <a href="index.php">Volver a la página principal</a></div>';
    } else {
        echo '<div class="alert error">Error: ' . $conn->error . '</div>';
    }
} else if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $post_id = intval($post_id);
} else {
    echo '<div class="alert error">No se proporcionó un ID de publicación.</div>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Comentario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Agregar Comentario</h1>
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
        <form method="post" action="add_comment.php">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
            <label>Comentario:</label>
            <textarea name="comment" rows="5" required></textarea>
            <br>
            <button type="submit">Agregar Comentario</button>
        </form>
        <br>
        <a class="btn-secondary" href="view_comments.php?post_id=<?php echo $post_id; ?>">Ver Comentarios</a> |
        <a class="btn-secondary" href="index.php">Volver a la página principal</a>
    </main>
    <footer>
        <p>&copy; 2024 Tu Nombre. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
