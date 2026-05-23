<?php
// Lista de todas las tablas permitidas
$tablas_validas = ['usuarios', 'generos', 'pelis', 'series', 'anime', 'libros', 'juegos'];
$tabla = $_GET['tabla'] ?? 'usuarios';

if (!in_array($tabla, $tablas_validas, true)) {
    $tabla = 'usuarios';
}

$conexion = mysqli_connect('localhost:3307', 'root', '', 'todo_check');
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$pk = ($tabla == 'usuarios') ? 'id_usuario' : 'id_' . substr($tabla, 0, -1);
// Ajuste especial para plurales irregulares
if ($tabla == 'series') $pk = 'id_serie';
if ($tabla == 'libros') $pk = 'id_libro';
if ($tabla == 'juegos') $pk = 'id_juego';

// --- ACCIONES POST ---
if (isset($_POST['borrar_id'])) {
    $id = intval($_POST['borrar_id']);
    $query = "DELETE FROM $tabla WHERE $pk = $id";
    if (!mysqli_query($conexion, $query)) {
        echo "<script>alert('Error al borrar: Verifica que no existan registros relacionados.');</script>";
    }
    header("Location: ?tabla=$tabla");
    exit;
}

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    if ($tabla == 'usuarios') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        // Solo actualizar contraseña si se escribe algo nuevo
        if (!empty($_POST['contra'])) {
            $contra = password_hash($_POST['contra'], PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET nombre='$nombre', email='$email', contraseña='$contra' WHERE id_usuario=$id";
        } else {
            $query = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id_usuario=$id";
        }
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
<!-- (El resto del HTML se mantiene igual, pero asegúrate de añadir el campo password en el bloque editar de usuarios) -->
