<?php
// Inicialización segura de variables
$tabla = $_POST['tabla'] ?? $_GET['tabla'] ?? 'usuarios';
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver datos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
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
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestión de Base de Datos</h1>
    
    <nav>
        <strong>Selecciona tabla:</strong> 
        <a href="ver.php?tabla=usuarios">Usuarios</a> | 
        <a href="ver.php?tabla=series">Series</a> | 
        <a href="index.php">Volver al Inicio</a>
    </nav>

    <?php
    $conexion = mysqli_connect('localhost:3307', 'root', '');
    mysqli_select_db($conexion, "todo_check");

    // Validación de la tabla
    if (!in_array($tabla, ['usuarios', 'series'])) {
        $tabla = 'usuarios';
    }

    // BORRAR USUARIO
    if ($accion == "borrar_usuario" && isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id && $id > 0) { // Comprobación: debe ser entero y positivo
            $delusu = mysqli_prepare($conexion,
                "DELETE FROM usuarios WHERE id = ?"
            );

            mysqli_stmt_bind_param($delusu, "i", $id);
            mysqli_stmt_execute($delusu);
            mysqli_stmt_close($delusu);
        }
        header("Location: ver.php?tabla=" . $tabla);
        exit();
    }

    // BORRAR SERIE
    if ($accion == "borrar_serie" && isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id && $id > 0) { // Comprobación: debe ser entero y positivo
            $delserie = mysqli_prepare($conexion,
                "DELETE FROM series WHERE id = ?"
            );

            mysqli_stmt_bind_param($delserie, "i", $id);
            mysqli_stmt_execute($delserie);
            mysqli_stmt_close($delserie);
        }
        header("Location: ver.php?tabla=" . $tabla);
        exit();
    }

    if ($tabla == "usuarios") {
    ?>

    <h2>Usuarios</h2>

    <table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>

    <?php
    $result = mysqli_query($conexion, "SELECT id, nombre FROM usuarios");

    while ($fila = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $fila['id']; ?></td>
        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
        <td>
            <form method="POST" onsubmit="return confirm('¿Estás seguro de borrar este usuario?');">
                <input type="hidden" name="tabla" value="usuarios">
                <input type="hidden" name="accion" value="borrar_usuario">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                <button type="submit">Borrar</button>
            </form>
        </td>
    </tr>
    <?php
    }
    ?>

    </table>

    <?php
    }

    // INTERFAZ SERIES
    if ($tabla == "series") {
    ?>

    <h2>Insertar Serie</h2>

    <form method="POST" action="insert.php?opcion=series">
        <input type="hidden" name="tabla" value="series">
        <input type="hidden" name="accion" value="guardar_serie">
        Título: <input type="text" name="titulo" required maxlength="20"><br><br>
        Descripción: <input type="text" name="descripcion" required maxlength="100"><br><br>
        <button type="submit" style="background-color: #28a745;">Guardar</button>
    </form>

    <h2>Series existentes</h2>

    <table>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>

    <?php
    $result = mysqli_query($conexion, "SELECT * FROM series");

    while ($fila = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $fila['id']; ?></td>
        <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
        <td>
            <form method="POST" onsubmit="return confirm('¿Estás seguro de borrar esta serie?');">
                <input type="hidden" name="tabla" value="series">
                <input type="hidden" name="accion" value="borrar_serie">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                <button type="submit">Borrar</button>
            </form>
        </td>
    </tr>
    <?php
    }
    ?>

    </table>

    <?php
    }
    ?>
</div>

</body>
</html>
