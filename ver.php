<?php
$tabla = $_GET['tabla'] ?? 'usuarios';

// Validación de la tabla para evitar accesos no deseados
if (!in_array($tabla, ['usuarios', 'series'], true)) {
    $tabla = 'usuarios';
}

$conexion = mysqli_connect('localhost:3306', 'root', '', 'todo_check');

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualización de Datos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        nav {
            background: #e9ecef;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        nav a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            margin-right: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        h2 {
            color: #2c3e50;
            border-left: 5px solid #007bff;
            padding-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestión de Base de Datos</h1>
    
    <nav>
        <strong>Selecciona tabla:</strong> 
        <a href="?tabla=usuarios">Usuarios</a> | 
        <a href="?tabla=series">Series</a> | 
        <a href="index.php">Volver al Inicio</a>
    </nav>

    <?php if ($tabla == "usuarios"): ?>
        <h2>Lista de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conexion, "SELECT id, nombre FROM usuarios");
                while ($fila = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $fila['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($tabla == "series"): ?>
        <h2>Catálogo de Series</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conexion, "SELECT * FROM series");
                while ($fila = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $fila['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($fila['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
