<?php
// Configuración
$servidor = 'localhost:3307';
$usuario = 'root';
$password = '';
$base = 'todo_check';

$conexion = mysqli_connect($servidor, $usuario, $password, $base);
if (!$conexion) die("Error de conexión: " . mysqli_connect_error());

// Validar tabla
$tablas_validas = ['usuarios', 'generos', 'pelis', 'series', 'anime', 'libros', 'juegos'];
$tabla = $_GET['tabla'] ?? 'usuarios';
if (!in_array($tabla, $tablas_validas, true)) $tabla = 'usuarios';

// Determinar Primary Key
$pk = ($tabla == 'usuarios') ? 'id_usuario' : 'id_' . substr($tabla, 0, -1);
if ($tabla == 'series') $pk = 'id_serie';
if ($tabla == 'libros') $pk = 'id_libro';
if ($tabla == 'juegos') $pk = 'id_juego';
if ($tabla == 'anime') $pk = 'id_anime';
if ($tabla == 'pelis') $pk = 'id_peli';
if ($tabla == 'generos') $pk = 'id_genero';

// --- ACCIONES POST ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Borrar
    if (isset($_POST['borrar'])) {
        $id = intval($_POST['id']);
        mysqli_query($conexion, "DELETE FROM $tabla WHERE $pk = $id");
    }
    // 2. Actualizar
    elseif (isset($_POST['actualizar'])) {
        $id = intval($_POST['id']);
        $set_parts = [];
        foreach ($_POST as $campo => $valor) {
            // Excluimos botones y el ID
            if ($campo != 'actualizar' && $campo != 'borrar' && $campo != 'id') {
                $val = mysqli_real_escape_string($conexion, $valor);
                $set_parts[] = "$campo = '$val'";
            }
        }
        $sql_update = "UPDATE $tabla SET " . implode(", ", $set_parts) . " WHERE $pk = $id";
        mysqli_query($conexion, $sql_update);
    }
    header("Location: ?tabla=$tabla");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar <?php echo $tabla; ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        input[type="text"] { width: 90%; padding: 5px; }
    </style>
</head>
<body>
    <h1>Administración de: <?php echo ucfirst($tabla); ?></h1>
    <a href="index.php">← Volver al Panel</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <?php
                $res = mysqli_query($conexion, "SELECT * FROM $tabla");
                $fields = mysqli_fetch_fields($res);
                foreach ($fields as $f) echo "<th>{$f->name}</th>";
                ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Reiniciar puntero para recorrer de nuevo
            mysqli_data_seek($res, 0); 
            while ($fila = mysqli_fetch_assoc($res)): 
            ?>
            <tr>
                <form method="POST">
                    <?php foreach ($fila as $columna => $valor): ?>
                        <td>
                            <?php if ($columna == $pk): ?>
                                <?php echo $valor; ?>
                                <input type="hidden" name="id" value="<?php echo $valor; ?>">
                            <?php else: ?>
                                <input type="text" name="<?php echo $columna; ?>" value="<?php echo htmlspecialchars($valor ?? ''); ?>">
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <button type="submit" name="actualizar">Guardar</button>
                        <button type="submit" name="borrar" onclick="return confirm('¿Seguro?')">Borrar</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
