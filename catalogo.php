<?php
$servidor = "localhost:3307"; // Asegúrate de que este puerto coincida con tu XAMPP
$usuario  = "root";
$pass     = "";
$base     = "todo_check";

$conexion = mysqli_connect($servidor, $usuario, $pass, $base) or die("Error de conexión: " . mysqli_connect_error());

// Consulta unificada
$query = "SELECT titulo, tipo, IFNULL(nombre_genero, 'Sin género') as nombre_genero 
          FROM biblioteca_total 
          ORDER BY tipo ASC, titulo ASC";

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Todo Check</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f9f9f9; padding: 40px; color: #333; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .tipo-badge { background: #007bff; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; }
        .btn-volver { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Catálogo Completo</h1>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Título</th>
                <th>Género</th>
            </tr>
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
    <a href="index.php" class="btn-volver">Volver al Panel</a>
</div>
</body>
</html>
