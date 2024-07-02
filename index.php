<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
</head>
<body>
    <h1>Bienvenido a la Página de Inicio</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hola, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="profile.php">Ver/Editar Perfil</a> |
        <a href="create_post.php">Crear Publicación</a> |
        <a href="view_posts.php">Ver Publicaciones</a> |
        <a href="view_categories.php">Ver Categorías</a> |
        <a href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <a href="register.php">Registro</a> |
        <a href="login.php">Iniciar Sesión</a>
    <?php endif; ?>
</body>
</html>
