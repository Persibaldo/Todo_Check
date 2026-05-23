<?php
// 1. Configuración de conexión
$servidor = "localhost:3307";
$usuario  = "root";
$pass     = "";
$base     = "todo_check";

$conexion = mysqli_connect($servidor, $usuario, $pass, $base) or die("Error de conexión");

// 2. Lógica de guardado lineal (solo si se envió el formulario POST)
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tabla'])) {
    $tabla_post = $_POST['tabla'];
    $sql = "";

    if ($tabla_post == 'usuarios') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        $contra = mysqli_real_escape_string($conexion, $_POST['contra']);
        $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES ('$nombre', '$email', '$contra')";
    } 
    elseif ($tabla_post == 'generos') {
        $nombre_genero = mysqli_real_escape_string($conexion, $_POST['nombre_genero']);
        $sql = "INSERT INTO generos (nombre_genero) VALUES ('$nombre_genero')";
    } 
    elseif ($tabla_post == 'pelis') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $director = mysqli_real_escape_string($conexion, $_POST['director']);
        $duracion = intval($_POST['duracion_min']);
        $sql = "INSERT INTO pelis (titulo, director, duracion_min) VALUES ('$titulo', '$director', $duracion)";
    } 
    elseif ($tabla_post == 'series') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $temporadas = intval($_POST['temporadas']);
        $en_emision = intval($_POST['en_emision']);
        $sql = "INSERT INTO series (titulo, temporadas, en_emision) VALUES ('$titulo', $temporadas, $en_emision)";
    } 
    elseif ($tabla_post == 'anime') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $estudio = mysqli_real_escape_string($conexion, $_POST['estudio']);
        $episodios = intval($_POST['episodios']);
        $sql = "INSERT INTO anime (titulo, estudio, episodios) VALUES ('$titulo', '$estudio', $episodios)";
    } 
    elseif ($tabla_post == 'libros') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $autor = mysqli_real_escape_string($conexion, $_POST['autor']);
        $paginas = intval($_POST['paginas']);
        $sql = "INSERT INTO libros (titulo, autor, paginas) VALUES ('$titulo', '$autor', $paginas)";
    } 
    elseif ($tabla_post == 'juegos') {
        $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
        $plataforma = mysqli_real_escape_string($conexion, $_POST['plataforma']);
        $desarrollador = mysqli_real_escape_string($conexion, $_POST['desarrollador']);
        $sql = "INSERT INTO juegos (titulo, plataforma, desarrollador) VALUES ('$titulo', '$plataforma', '$desarrollador')";
    }

    if ($sql !== "") {
        if (mysqli_query($conexion, $sql)) {
            $mensaje = "<p style='color:green; font-weight:bold;'>Datos guardados correctamente en la tabla " . htmlspecialchars($tabla_post) . "</p>";
        } else {
            $mensaje = "<p style='color:red; font-weight:bold;'>Error al guardar: " . mysqli_error($conexion) . "</p>";
        }
    }
}

// 3. Determinar qué formulario mostrar (Prioridad a 'tabla', fallback a 'opcion')
$tabla = $_GET['tabla'] ?? $_GET['opcion'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Datos - Todo Check</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px; color: #333; }
        nav { background: #e9ecef; padding: 12px; border-radius: 6px; margin-bottom: 25px; display: flex; flex-wrap: wrap; gap: 15px; }
        nav a { text-decoration: none; color: #007bff; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .formulario { background: white; border: 1px solid #dee2e6; padding: 20px; width: 350px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin: 0 auto; }
        h2 { color: #2c3e50; font-size: 1.5rem; margin-bottom: 15px; }
        input, select { margin-bottom: 15px; display: block; width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; border: none; padding: 10px; width: 100%; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

    <h1>Gestión de Base de Datos - Inserción</h1>
    
    <nav>
        <strong>Selecciona tabla:</strong> 
        <a href="?tabla=usuarios">Usuarios</a> | 
        <a href="?tabla=generos">Géneros</a> | 
        <a href="?tabla=pelis">Películas</a> | 
        <a href="?tabla=series">Series</a> | 
        <a href="?tabla=anime">Anime</a> | 
        <a href="?tabla=libros">Libros</a> | 
        <a href="?tabla=juegos">Juegos</a> |
        <a href="ver.php?tabla=<?php echo $tabla; ?>"" style="color: #28a745;">&#128065; Ver datos existentes</a>
    </nav>

    <div style="text-align: center;">
        <?php echo $mensaje; ?>
    </div>

    <?php if ($tabla == 'usuarios'): ?>
        <div class="formulario">
            <h3>Nuevo Usuario</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="usuarios">
                Nombre: <input type="text" name="nombre" required>
                Email: <input type="email" name="email" required>
                Contraseña: <input type="password" name="contra" required>
                <button type="submit">Guardar Usuario</button>
            </form>
        </div>

    <?php elseif ($tabla == 'generos'): ?>
        <div class="formulario">
            <h3>Nuevo Género</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="generos">
                Nombre del género: <input type="text" name="nombre_genero" required>
                <button type="submit">Guardar Género</button>
            </form>
        </div>

    <?php elseif ($tabla == 'pelis'): ?>
        <div class="formulario">
            <h3>Nueva Película</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="pelis">
                Título: <input type="text" name="titulo" required>
                Director: <input type="text" name="director" required>
                Duración (min): <input type="number" name="duracion_min" required>
                <button type="submit">Guardar Película</button>
            </form>
        </div>

    <?php elseif ($tabla == 'series'): ?>
        <div class="formulario">
            <h3>Nueva Serie</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="series">
                Título: <input type="text" name="titulo" required>
                Temporadas: <input type="number" name="temporadas" required>
                En emisión?: 
                <select name="en_emision"><option value="1">Sí</option><option value="0">No</option></select>
                <button type="submit">Guardar Serie</button>
            </form>
        </div>

    <?php elseif ($tabla == 'anime'): ?>
        <div class="formulario">
            <h3>Nuevo Anime</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="anime">
                Título: <input type="text" name="titulo" required>
                Estudio: <input type="text" name="estudio" required>
                Episodios: <input type="number" name="episodios" required>
                <button type="submit">Guardar Anime</button>
            </form>
        </div>

    <?php elseif ($tabla == 'libros'): ?>
        <div class="formulario">
            <h3>Nuevo Libro</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="libros">
                Título: <input type="text" name="titulo" required>
                Autor: <input type="text" name="autor" required>
                Páginas: <input type="number" name="paginas" required>
                <button type="submit">Guardar Libro</button>
            </form>
        </div>

    <?php elseif ($tabla == 'juegos'): ?>
        <div class="formulario">
            <h3>Nuevo Juego</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="juegos">
                Título: <input type="text" name="titulo" required>
                Plataforma: <input type="text" name="plataforma" required>
                Desarrollador: <input type="text" name="desarrollador" required>
                <button type="submit">Guardar Juego</button>
            </form>
        </div>

    <?php else: ?>
        <div style="text-align: center; margin-top: 50px;">
            <p style="font-size: 1.2rem; color: #6c757d;">Por favor, elige una categoría en el menú superior.</p>
        </div>
    <?php endif; ?>

</body>
</html>
