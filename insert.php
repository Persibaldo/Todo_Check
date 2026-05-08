<?php
// 1. Configuración de conexión
$servidor = "localhost:3307";
$usuario  = "root";
$pass     = "";
$base     = "todo_check";

$conexion = mysqli_connect($servidor, $usuario, $pass, $base) or die("Error de conexión");

// 2. Función para procesar la inserción
function ejecutarInsercion($con, $tabla, $datos) {
    if ($tabla == 'usuarios') {
        $nombre = mysqli_real_escape_string($con, $datos['nombre']);
        // Encriptamos la contraseña
        $contra = password_hash($datos['contra'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, contraseña) VALUES ('$nombre', '$contra')";
    } else {
        $titulo = mysqli_real_escape_string($con, $datos['titulo']);
        $desc = mysqli_real_escape_string($con, $datos['descripcion']); // Corrección de sintaxis añadida
        $sql = "INSERT INTO series (titulo, descripcion) VALUES ('$titulo', '$desc')";
    }
    return mysqli_query($con, $sql);
}

// 3. Lógica de guardado (solo si se envió el formulario POST)
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tabla'])) {
    if (ejecutarInsercion($conexion, $_POST['tabla'], $_POST)) {
        $mensaje = "<p style='color:green;'>Datos guardados correctamente en " . htmlspecialchars($_POST['tabla']) . "</p>";
    } else {
        $mensaje = "<p style='color:red;'>Error al guardar: " . mysqli_error($conexion) . "</p>";
    }
}

// 4. Determinar qué formulario mostrar vía GET
$opcion = $_GET['opcion'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Percival">
    <title>Insertar Datos - Todo Check</title>
    <style>
        /* estilos */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
}

nav {
    background: #e9ecef;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 25px;
}

nav a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    margin-right: 15px;
}

.formulario {
    background: white;
    border: 1px solid #dee2e6;
    padding: 20px;
    width: 320px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    margin: 0 auto;
}

/* titulos dentro del formulario o página */
h2 {
    color: #2c3e50;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

input {
    margin-bottom: 15px;
    display: block;
    width: 100%; /* ocupa el ancho total del contenedor .formulario */
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box; /* para que el padding no rompa el ancho */
    font-family: inherit;
}

input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

/* Estilo botón de envío*/
button, input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}

button:hover, input[type="submit"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>

    <h1>Gestión de Base de Datos</h1>
    
    <nav>
        <strong>Selecciona tabla:</strong> 
        <a href="?opcion=usuarios">Usuarios</a> | 
        <a href="?opcion=series">Series</a> |
        <a href="ver.php">Ver datos</a>
    </nav>

    <?php echo $mensaje; ?>

    <?php if ($opcion == 'usuarios'): ?>
        <div class="formulario">
            <h3>Nuevo Usuario</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="usuarios">
                Nombre: <input type="text" name="nombre" required maxlength="20">
                Contraseña: <input type="password" name="contra" required>
                <button type="submit">Guardar Usuario</button>
            </form>
        </div>
        
    <?php elseif ($opcion == 'series'): ?>
        <div class="formulario">
            <h3>Nueva Serie</h3>
            <form method="POST">
                <input type="hidden" name="tabla" value="series">
                Título de la serie: <input type="text" name="titulo" required maxlength="80">
                Breve descripción: <input type="text" name="descripcion" required maxlength="200">
                <button type="submit">Guardar Serie</button>
            </form>
        </div>

    <?php else: ?>
        <p>Por favor, elige una opción en el menú superior para insertar datos.</p>
    <?php endif; ?>

</body>
</html>
