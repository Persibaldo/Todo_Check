<?php
// Configuración
$servidor = 'localhost:3307';
$usuario = 'root';
$password = '';
$base = 'todo_check';

$conexion = mysqli_connect($servidor, $usuario, $password, $base);
if (!$conexion) die("Error de conexión: " . mysqli_connect_error());

// Definir tabla válidas con su primary key (elimina duplicación de código)
$tablas_config = [
    'usuarios' => 'id_usuario',
    'generos' => 'id_genero',
    'pelis' => 'id_peli',
    'series' => 'id_serie',
    'anime' => 'id_anime',
    'libros' => 'id_libro',
    'juegos' => 'id_juego'
];

$tabla = $_GET['tabla'] ?? 'usuarios';

// Validar tabla contra lista blanca
if (!array_key_exists($tabla, $tablas_config)) {
    $tabla = 'usuarios';
}

$pk = $tablas_config[$tabla];

// --- ACCIONES POST ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que tabla sigue siendo válida
    if (!array_key_exists($tabla, $tablas_config)) {
        die("Error: Tabla no válida.");
    }
    
    // 1. Borrar
    if (isset($_POST['borrar'])) {
        $id = intval($_POST['id']);
        
        // Validar que el ID es válido (positivo)
        if ($id > 0) {
            // Usar prepared statement para evitar SQL injection
            $stmt = $conexion->prepare("DELETE FROM " . $tabla . " WHERE " . $pk . " = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }
    // 2. Actualizar
    elseif (isset($_POST['actualizar'])) {
        $id = intval($_POST['id']);
        
        // Validar que el ID es válido (positivo)
        if ($id > 0) {
            $set_parts = [];
            $tipos = '';
            $valores = [];
            
            // Obtener campos de la tabla
            $res = mysqli_query($conexion, "SELECT * FROM $tabla LIMIT 1");
            $fields = mysqli_fetch_fields($res);
            $campos_validos = [];
            
            foreach ($fields as $f) {
                $campos_validos[$f->name] = $f->type;
            }
            
            // Construir query actualizado con validación de campos
            foreach ($_POST as $campo => $valor) {
                // Excluimos botones y el ID
                if ($campo != 'actualizar' && $campo != 'borrar' && $campo != 'id' && isset($campos_validos[$campo])) {
                    $val = trim($valor);
                    
                    // Validaciones básicas según tipo
                    if (in_array($campos_validos[$campo], ['INT', 'LONG', 'TINY'])) {
                        $val = intval($val);
                        $tipos .= 'i';
                    } elseif (in_array($campos_validos[$campo], ['BLOB', 'STRING', 'VAR_STRING'])) {
                        $val = trim($val);
                        $tipos .= 's';
                        
                        // Validar longitud máxima según el campo
                        $max_lengths = [
                            'nombre' => 100,
                            'email' => 100,
                            'contraseña' => 20,
                            'nombre_genero' => 50,
                            'titulo' => 255,
                            'director' => 100,
                            'estudio' => 100,
                            'autor' => 100,
                            'plataforma' => 100,
                            'desarrollador' => 100
                        ];
                        
                        if (isset($max_lengths[$campo]) && strlen($val) > $max_lengths[$campo]) {
                            $val = substr($val, 0, $max_lengths[$campo]);
                        }
                    }
                    
                    $set_parts[] = "$campo = ?";
                    $valores[] = $val;
                }
            }
            
            if (!empty($set_parts)) {
                $sql_update = "UPDATE $tabla SET " . implode(", ", $set_parts) . " WHERE $pk = ?";
                $stmt = $conexion->prepare($sql_update);
                
                // Agregar el ID al final
                $tipos .= 'i';
                $valores[] = $id;
                
                // Bind dinámicamente
                $stmt->bind_param($tipos, ...$valores);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    
    header("Location: ?tabla=$tabla");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar <?php echo htmlspecialchars($tabla); ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f9f9f9; }
        h1 { color: #2c3e50; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f0f0f0; }
        input[type="text"], input[type="email"], input[type="number"], input[type="password"] { width: 90%; padding: 6px; border: 1px solid #ccc; border-radius: 3px; }
        button { padding: 6px 12px; margin: 0 3px; border: none; border-radius: 3px; cursor: pointer; font-weight: bold; }
        button[name="actualizar"] { background-color: #28a745; color: white; }
        button[name="actualizar"]:hover { background-color: #218838; }
        button[name="borrar"] { background-color: #dc3545; color: white; }
        button[name="borrar"]:hover { background-color: #c82333; }
        form { display: contents; }
    </style>
</head>
<body>
    <h1>Administración de: <?php echo htmlspecialchars(ucfirst($tabla)); ?></h1>
    <a href="index.php">← Volver al Panel</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <?php
                $res = mysqli_query($conexion, "SELECT * FROM $tabla LIMIT 1");
                if ($res) {
                    $fields = mysqli_fetch_fields($res);
                    foreach ($fields as $f) {
                        echo "<th>" . htmlspecialchars($f->name) . "</th>";
                    }
                }
                ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Ejecutar query para obtener datos
            $res = mysqli_query($conexion, "SELECT * FROM $tabla");
            
            if ($res && mysqli_num_rows($res) > 0) {
                while ($fila = mysqli_fetch_assoc($res)): 
                ?>
                <tr>
                    <form method="POST">
                        <?php foreach ($fila as $columna => $valor): ?>
                            <td>
                                <?php if ($columna == $pk): ?>
                                    <?php echo htmlspecialchars($valor); ?>
                                    <input type="hidden" name="id" value="<?php echo intval($valor); ?>">
                                <?php else: ?>
                                    <input type="text" name="<?php echo htmlspecialchars($columna); ?>" value="<?php echo htmlspecialchars($valor ?? ''); ?>" maxlength="255">
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                        <td>
                            <button type="submit" name="actualizar">Guardar</button>
                            <button type="submit" name="borrar" onclick="return confirm('¿Estás seguro de que deseas borrar este registro?')">Borrar</button>
                        </td>
                    </form>
                </tr>
                <?php endwhile;
            } else {
                echo "<tr><td colspan='100%' style='text-align: center; color: #999;'>No hay datos en esta tabla.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
