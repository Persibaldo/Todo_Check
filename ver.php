<?php
// --- CONFIGURACIÓN ---
$servidor = 'localhost:3307';
$usuario = 'root';
$password = '';
$base = 'todo_check';

$conexion = mysqli_connect($servidor, $usuario, $password, $base);
if (!$conexion) die("Error de conexión: " . mysqli_connect_error());

$tablas_config = ['usuarios'=>'id_usuario', 'generos'=>'id_genero', 'pelis'=>'id_peli', 'series'=>'id_serie', 'anime'=>'id_anime', 'libros'=>'id_libro', 'juegos'=>'id_juego'];
$tabla = $_GET['tabla'] ?? 'usuarios';
if (!array_key_exists($tabla, $tablas_config)) { $tabla = 'usuarios'; }
$pk = $tablas_config[$tabla];

// --- ACCIONES POST ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['borrar'])) {
        $stmt = $conexion->prepare("DELETE FROM $tabla WHERE $pk = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } elseif (isset($_POST['actualizar'])) {
        $sql = "UPDATE $tabla SET ";
        $params = []; $types = "";
        foreach($_POST as $k => $v) {
            if($k != 'actualizar' && $k != 'id') {
                $sql .= "$k = ?, ";
                $params[] = $v;
                $types .= "s";
            }
        }
        $sql = rtrim($sql, ", ") . " WHERE $pk = ?";
        $params[] = $_POST['id'];
        $types .= "i";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
    }
    header("Location: ?tabla=$tabla");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar <?php echo ucfirst($tabla); ?></title>
    <style>
        /* CSS EMBEBIDO PARA ASEGURAR ESTILOS */
        body { margin: 0; padding: 20px; background-color: #f1f5f9; font-family: sans-serif; }
        
        .full-screen-wrapper { width: 98%; margin: 0 auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        h1 { color: #1e293b; margin-top: 0; }
        
        /* Estilos de botones */
        .btn { padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; color: white; font-weight: 600; text-decoration: none; display: inline-block; font-size: 14px; margin: 2px; }
        .btn-save { background-color: #22c55e; } /* Verde */
        .btn-save:hover { background-color: #16a34a; }
        .btn-delete { background-color: #ef4444; } /* Rojo */
        .btn-delete:hover { background-color: #dc2626; }
        .btn-back { background-color: #475569; } /* Gris Oscuro */
        .btn-back:hover { background-color: #334155; }

        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .admin-table th { background: #334155; color: white; padding: 12px; text-align: left; }
        .admin-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .admin-table input { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; }
        .actions-cell { width: 180px; white-space: nowrap; }
    </style>
</head>
<body>

<div class="full-screen-wrapper">
    <h1>Administrando: <?php echo htmlspecialchars(ucfirst($tabla)); ?></h1>
    <a href="index.php" class="btn btn-back">← Volver al Panel</a>

    <table class="admin-table">
        <thead>
            <tr>
                <?php
                $res = mysqli_query($conexion, "SELECT * FROM $tabla");
                $fields = mysqli_fetch_fields($res);
                foreach ($fields as $f) echo "<th>" . htmlspecialchars($f->name) . "</th>";
                echo "<th>Acciones</th>";
                ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($res)): ?>
            <tr>
                <form method="POST">
                    <?php foreach ($fila as $col => $val): ?>
                        <td>
                            <?php if ($col == $pk): ?>
                                <strong><?php echo htmlspecialchars($val); ?></strong>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($val); ?>">
                            <?php else: ?>
                                <input type="text" name="<?php echo htmlspecialchars($col); ?>" value="<?php echo htmlspecialchars($val ?? ''); ?>">
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td class="actions-cell">
                        <button type="submit" name="actualizar" class="btn btn-save">Guardar</button>
                        <button type="submit" name="borrar" class="btn btn-delete" onclick="return confirm('¿Borrar registro?')">Borrar</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
