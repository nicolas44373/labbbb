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
</head>
<body>
    <h1>Categorías</h1>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li><?php echo htmlspecialchars($row['name']); ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No hay categorías disponibles.</p>
    <?php endif; ?>
    <br>
    <a href="create_category.php">Crear Categoría</a> |
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
