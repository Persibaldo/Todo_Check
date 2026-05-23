<?php
// 1. Configuración de conexión
$servidor = "localhost:3307";
$usuario  = "root";
$pass     = "";
$base     = "todo_check";

$conexion = mysqli_connect($servidor, $usuario, $pass, $base) or die("Error de conexión");

// 2. Consulta a la VISTA (uniendo con géneros para obtener el nombre)
// Ordenamos por tipo y luego por título para que quede organizado
$query = "
    SELECT b.titulo, b.tipo, g.nombre_genero 
    FROM biblioteca_total b 
    JOIN generos g ON b.id_genero = g.id_genero
    ORDER BY b.tipo ASC, b.titulo ASC
";

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Percival">
    <title>Biblioteca - Todo Check</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; text-align: center; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .tipo-badge { 
            padding: 4px 8px; 
            border-radius: 12px; 
            font-size: 0.85em; 
            font-weight: bold; 
            color: white; 
            background-color: #6c757d; 
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Catálogo Completo</h1>
    <p style="text-align: center; color: #666;">Explora todo nuestro contenido disponible.</p>

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
                    <td>
                        <span class="tipo-badge">
                            <?php echo htmlspecialchars($fila['tipo']); ?>
                        </span>
                    </td>
                    <td style="font-weight: 500;">
                        <?php echo htmlspecialchars($fila['titulo']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($fila['nombre_genero']); ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
