<?php
$tabla = $_GET['tabla'] ?? 'usuarios';

// Validación de la tabla
if (!in_array($tabla, ['usuarios', 'series'], true)) {
    $tabla = 'usuarios';
}

$conexion = mysqli_connect('localhost:3307', 'root', '', 'todo_check');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// --- FUNCIONAMIENTO TRAS EL (POST) ---

// 1. Borrar registro
if (isset($_POST['borrar_id'])) {
    $id = intval($_POST['borrar_id']);
    $query = "DELETE FROM $tabla WHERE id = $id";
    mysqli_query($conexion, $query); // Hace que se ejecute lo que hay almacenado en $query dentro de $conexion 
    header("Location: ?tabla=$tabla"); // Recargar para limpiar el POST
    exit;
}

// 2. Actualizar registro (Editar)
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    if ($tabla == 'usuarios') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']); //mysqli_real_escape_string es para poder insertar un dato
        $query = "UPDATE usuarios SET nombre='$nombre' WHERE id=$id"; //Una sentencia que actualiza el nombre del usuario dond esu ID sea el mismo ID
    } else {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $desc = mysqli_real_escape_string($conexion, $_POST['descripcion']);
        $query = "UPDATE series SET titulo='$titulo', descripcion='$desc' WHERE id=$id";
    }
    mysqli_query($conexion, $query);
    header("Location: ?tabla=$tabla");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Datos</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto; }
        nav { background: #e9ecef; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        nav a { text-decoration: none; color: #007bff; font-weight: bold; margin-right: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #343a40; color: white; }
        .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; color: white; }
        .btn-edit { background-color: #5daadd; color: #212529; }
        .btn-delete { background-color: #dc3545; }
        .edit-row { background-color: #fff9e6 !important; }
        input[type="text"] { padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestión de Base de Datos</h1>
    
    <nav>
        <a href="?tabla=usuarios">Usuarios</a> | 
        <a href="?tabla=series">Series</a> | 
        <a href="index.php">Volver al Inicio</a>
    </nav>

    <h2><?php echo ($tabla == 'usuarios') ? 'Lista de Usuarios' : 'Colección de Series'; ?></h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <?php if ($tabla == 'usuarios'): ?>
                    <th>Nombre</th>
                <?php else: ?>
                    <th>Título</th>
                    <th>Descripción</th>
                <?php endif; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = ($tabla == 'usuarios') ? "SELECT id, nombre FROM usuarios" : "SELECT * FROM series";
            $result = mysqli_query($conexion, $query);

            while ($fila = mysqli_fetch_assoc($result)): 
                // Comprobamos si el usuario quiere editar esta fila específica
                $editando = (isset($_GET['edit']) && $_GET['edit'] == $fila['id']);
            ?>
            <tr class="<?php echo $editando ? 'edit-row' : ''; ?>"> <!--Cuándo se edita se crea un campo en el que se mete la nueva información-->
                    <form method="POST">
                        <td><?php echo $fila['id']; ?> <input type="hidden" name="id" value="<?php echo $fila['id']; ?>"></td>
                        <!--Aquí lo que hace es coger el valor de fila y mantenerlo ya que ID es el primer valor que hay dentro de fila-->
                        <?php if ($tabla == 'usuarios'): ?>
                            <td>
                                <?php if ($editando): ?>
                                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>" required>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($fila['nombre']); ?>
                                <?php endif; ?>
                            </td>
                        <?php else: ?>
                            <td>
                                <?php if ($editando): ?>
                                    <input type="text" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($fila['titulo']); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($editando): ?>
                                    <input type="text" name="descripcion" value="<?php echo htmlspecialchars($fila['descripcion']); ?>" required>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($fila['descripcion']); ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                        <td>
                            <?php if ($editando): ?>
                                <button type="submit" name="actualizar" class="btn" style="background-color: #28a745;">Guardar</button>
                                <a href="?tabla=<?php echo $tabla; ?>" class="btn" style="background-color: #6c757d;">Cancelar</a>
                            <?php else: ?>
                            <!-- En caso de que no se esté editando, cambiaría a ser de estos colores-->
                                <a href="?tabla=<?php echo $tabla; ?>&edit=<?php echo $fila['id']; ?>" class="btn btn-edit">Editar</a>
                                
                                <button type="submit" name="borrar_id" value="<?php echo $fila['id']; ?>" 
                                        class="btn btn-delete" onclick="return confirm('¿Seguro que deseas borrar esto?')">Borrar</button>
                            <?php endif; ?>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
