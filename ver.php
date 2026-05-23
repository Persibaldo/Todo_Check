<?php
// Lista de todas las tablas permitidas
$tablas_validas = ['usuarios', 'generos', 'pelis', 'series', 'anime', 'libros', 'juegos'];
$tabla = $_GET['tabla'] ?? 'usuarios';

// Validación de la tabla
if (!in_array($tabla, $tablas_validas, true)) {
    $tabla = 'usuarios';
}

$conexion = mysqli_connect('localhost:3307', 'root', '', 'todo_check');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Determinar el nombre de la clave primaria (PK) según la tabla
$pk = 'id_usuario';
if ($tabla == 'generos') $pk = 'id_genero';
if ($tabla == 'pelis') $pk = 'id_peli';
if ($tabla == 'series') $pk = 'id_serie';
if ($tabla == 'anime') $pk = 'id_anime';
if ($tabla == 'libros') $pk = 'id_libro';
if ($tabla == 'juegos') $pk = 'id_juego';

// --- FUNCIONAMIENTO TRAS EL (POST) ---

// 1. Borrar registro
if (isset($_POST['borrar_id'])) {
    $id = intval($_POST['borrar_id']);
    $query = "DELETE FROM $tabla WHERE $pk = $id";
    mysqli_query($conexion, $query); 
    header("Location: ?tabla=$tabla"); 
    exit;
}

// 2. Actualizar registro (Editar)
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);

    if ($tabla == 'usuarios') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        $query = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id_usuario=$id";
    } 
    elseif ($tabla == 'generos') {
        $nombre_genero = mysqli_real_escape_string($conexion, $_POST['nombre_genero']);
        $query = "UPDATE generos SET nombre_genero='$nombre_genero' WHERE id_genero=$id";
    } 
    elseif ($tabla == 'pelis') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $director = mysqli_real_escape_string($conexion, $_POST['director']);
        $duracion = intval($_POST['duracion_min']);
        $query = "UPDATE pelis SET titulo='$titulo', director='$director', duracion_min=$duracion WHERE id_peli=$id";
    } 
    elseif ($tabla == 'series') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $temporadas = intval($_POST['temporadas']);
        $en_emision = intval($_POST['en_emision']);
        $query = "UPDATE series SET titulo='$titulo', temporadas=$temporadas, en_emision=$en_emision WHERE id_serie=$id";
    } 
    elseif ($tabla == 'anime') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $estudio = mysqli_real_escape_string($conexion, $_POST['estudio']);
        $episodios = intval($_POST['episodios']);
        $query = "UPDATE anime SET titulo='$titulo', estudio='$estudio', episodios=$episodios WHERE id_anime=$id";
    } 
    elseif ($tabla == 'libros') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $autor = mysqli_real_escape_string($conexion, $_POST['autor']);
        $paginas = intval($_POST['paginas']);
        $query = "UPDATE libros SET titulo='$titulo', autor='$autor', paginas=$paginas WHERE id_libro=$id";
    } 
    elseif ($tabla == 'juegos') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $plataforma = mysqli_real_escape_string($conexion, $_POST['plataforma']);
        $desarrollador = mysqli_real_escape_string($conexion, $_POST['desarrollador']);
        $query = "UPDATE juegos SET titulo='$titulo', plataforma='$plataforma', desarrollador='$desarrollador' WHERE id_juego=$id";
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
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 1000px; margin: 0 auto; }
        nav { background: #e9ecef; padding: 12px; border-radius: 6px; margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px; }
        nav a { text-decoration: none; color: #007bff; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #343a40; color: white; }
        .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; color: white; margin-right: 5px; }
        .btn-edit { background-color: #5daadd; color: #212529; }
        .btn-delete { background-color: #dc3545; }
        .edit-row { background-color: #fff9e6 !important; }
        input[type="text"], input[type="number"], select { padding: 5px; border: 1px solid #ccc; border-radius: 4px; width: 90%; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestión de Base de Datos</h1>
    
    <nav>
        <a href="?tabla=usuarios">Usuarios</a> | 
        <a href="?tabla=generos">Géneros</a> | 
        <a href="?tabla=pelis">Películas</a> | 
        <a href="?tabla=series">Series</a> | 
        <a href="?tabla=anime">Anime</a> | 
        <a href="?tabla=libros">Libros</a> | 
        <a href="?tabla=juegos">Juegos</a>
    </nav>

    <h2>Visualizando tabla: <?php echo strtoupper($tabla); ?></h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <?php if ($tabla == 'usuarios'): ?>
                    <th>Nombre</th><th>Email</th>
                <?php elseif ($tabla == 'generos'): ?>
                    <th>Género</th>
                <?php elseif ($tabla == 'pelis'): ?>
                    <th>Título</th><th>Director</th><th>Duración (min)</th>
                <?php elseif ($tabla == 'series'): ?>
                    <th>Título</th><th>Temporadas</th><th>En Emisión</th>
                <?php elseif ($tabla == 'anime'): ?>
                    <th>Título</th><th>Estudio</th><th>Episodios</th>
                <?php elseif ($tabla == 'libros'): ?>
                    <th>Título</th><th>Autor</th><th>Páginas</th>
                <?php elseif ($tabla == 'juegos'): ?>
                    <th>Título</th><th>Plataforma</th><th>Desarrollador</th>
                <?php endif; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM $tabla";
            $result = mysqli_query($conexion, $query);

            while ($fila = mysqli_fetch_assoc($result)): 
                // Comprobamos si el usuario quiere editar esta fila específica
                $editando = (isset($_GET['edit']) && $_GET['edit'] == $fila[$pk]);
            ?>
            <tr class="<?php echo $editando ? 'edit-row' : ''; ?>">
                <form method="POST">
                    <td>
                        <?php echo $fila[$pk]; ?> 
                        <input type="hidden" name="id" value="<?php echo $fila[$pk]; ?>">
                    </td>
                    
                    <?php if ($tabla == 'usuarios'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['nombre']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="email" value="<?php echo htmlspecialchars($fila['email']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['email']); endif; ?>
                        </td>

                    <?php elseif ($tabla == 'generos'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="nombre_genero" value="<?php echo htmlspecialchars($fila['nombre_genero']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['nombre_genero']); endif; ?>
                        </td>

                    <?php elseif ($tabla == 'pelis'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['titulo']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="director" value="<?php echo htmlspecialchars($fila['director']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['director']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="number" name="duracion_min" value="<?php echo htmlspecialchars($fila['duracion_min']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['duracion_min']); endif; ?>
                        </td>

                    <?php elseif ($tabla == 'series'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['titulo']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="number" name="temporadas" value="<?php echo htmlspecialchars($fila['temporadas']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['temporadas']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <select name="en_emision">
                                    <option value="1" <?php if($fila['en_emision']) echo 'selected'; ?>>Sí</option>
                                    <option value="0" <?php if(!$fila['en_emision']) echo 'selected'; ?>>No</option>
                                </select>
                            <?php else: echo $fila['en_emision'] ? 'Sí' : 'No'; endif; ?>
                        </td>

                    <?php elseif ($tabla == 'anime'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['titulo']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="estudio" value="<?php echo htmlspecialchars($fila['estudio']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['estudio']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="number" name="episodios" value="<?php echo htmlspecialchars($fila['episodios']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['episodios']); endif; ?>
                        </td>

                    <?php elseif ($tabla == 'libros'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['titulo']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="autor" value="<?php echo htmlspecialchars($fila['autor']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['autor']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="number" name="paginas" value="<?php echo htmlspecialchars($fila['paginas']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['paginas']); endif; ?>
                        </td>

                    <?php elseif ($tabla == 'juegos'): ?>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['titulo']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="plataforma" value="<?php echo htmlspecialchars($fila['plataforma']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['plataforma']); endif; ?>
                        </td>
                        <td>
                            <?php if ($editando): ?>
                                <input type="text" name="desarrollador" value="<?php echo htmlspecialchars($fila['desarrollador']); ?>" required>
                            <?php else: echo htmlspecialchars($fila['desarrollador']); endif; ?>
                        </td>
                    <?php endif; ?>

                    <td>
                        <?php if ($editando): ?>
                            <button type="submit" name="actualizar" class="btn" style="background-color: #28a745;">Guardar</button>
                            <a href="?tabla=<?php echo $tabla; ?>" class="btn" style="background-color: #6c757d;">Cancelar</a>
                        <?php else: ?>
                            <a href="?tabla=<?php echo $tabla; ?>&edit=<?php echo $fila[$pk]; ?>" class="btn btn-edit">Editar</a>
                            <button type="submit" name="borrar_id" value="<?php echo $fila[$pk]; ?>" 
                                    class="btn btn-delete" onclick="return confirm('¿Seguro que deseas borrar este registro?')">Borrar</button>
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
