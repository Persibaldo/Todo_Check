<?php
$servidor = "localhost:3307";
$usuario  = "root";
$pass     = "";
$base     = "todo_check";

$conexion = mysqli_connect($servidor, $usuario, $pass, $base) or die("Error de conexión");

// Consulta corregida con LEFT JOIN
$query = "
    SELECT b.titulo, b.tipo, IFNULL(g.nombre_genero, 'Sin género') as nombre_genero 
    FROM biblioteca_total b 
    LEFT JOIN generos g ON b.id_genero = g.id_genero
    ORDER BY b.tipo ASC, b.titulo ASC
";

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Todo Check</title>
    <!-- Estilos iguales a tu versión original -->
</head>
<body>
<div class="container">
    <h1>Catálogo Completo</h1>
    <table>
        <thead>
            <tr><th>Tipo</th><th>Título</th><th>Género</th></tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><span class="tipo-badge"><?php echo htmlspecialchars($fila['tipo']); ?></span></td>
                    <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_genero']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
