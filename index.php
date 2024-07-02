<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bienvenido al foro mundial</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <p>Hola, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                    <a href="profile.php">Ver/Editar Perfil</a>
                    <a href="create_post.php">Crear Publicación</a>
                    <a href="view_posts.php">Ver Publicaciones</a>
                    <a href="view_categories.php">Ver Categorías</a>
                    <a href="logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="register.php">Registro</a>
                    <a href="login.php">Iniciar Sesión</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">
        <section class="intro">
            <h2>Explora Nuestro Sitio</h2>
            <p>Descubre publicaciones, categorías y mucho más en nuestra plataforma. Regístrate o inicia sesión para comenzar.</p>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> blog mundial. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
