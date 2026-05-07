<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Percival">
    <title>Creación de la BD</title>
</head>
<body>
<?php
// Configuración de conexión
$servidor = 'localhost:3306';
$usuario = 'root';
$password = '';

// 1. Establecer conexión
$conexion = mysqli_connect($servidor, $usuario, $password);

if (!$conexion) {
    die("La Conexión ha fallado: " . mysqli_connect_error());
}

// 2. Crear BD
$sql = "CREATE DATABASE IF NOT EXISTS todo_check";
if (mysqli_query($conexion, $sql)) {
    echo "Base de datos creada o ya existente.<br>";
} else {
    echo "Error creando BD: " . mysqli_error($conexion) . "<br>";
}

// 3. Seleccionar la BD
mysqli_select_db($conexion, "todo_check");

// --- TABLA SERIES ---
$sql2 = "CREATE TABLE IF NOT EXISTS series(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    titulo VARCHAR(20), 
    descripcion VARCHAR(100)
)";

if (mysqli_query($conexion, $sql2)) {
    echo "Tabla series lista.<br>";
    
    // Verificar si está vacía antes de insertar
    $checkSeries = mysqli_query($conexion, "SELECT id FROM series LIMIT 1");
    if (mysqli_num_rows($checkSeries) == 0) {
        $sql3 = "INSERT INTO series (titulo, descripcion) VALUES 
                ('The Mandalorian', 'Acción en la galaxia.'),
                ('Friends', 'Comedia de amigos en NY.')";
        mysqli_query($conexion, $sql3);
        echo "Datos de ejemplo en 'series' cargados.<br>";
    }
} else {
    echo "Error al crear tabla series: " . mysqli_error($conexion) . "<br>";
}

// --- TABLA USUARIOS ---
$sql4 = "CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(20), 
    contraseña VARCHAR(255)
)";

if (mysqli_query($conexion, $sql4)) {
    echo "Tabla usuarios lista.<br>";
    
    // Verificar si está vacía antes de insertar
    $checkUsers = mysqli_query($conexion, "SELECT id FROM usuarios LIMIT 1");
    if (mysqli_num_rows($checkUsers) == 0) {
        $sql5 = "INSERT INTO usuarios (nombre, contraseña) VALUES 
                ('admin', '1234'), 
                ('percival', 'pass123')";
        mysqli_query($conexion, $sql5);
        echo "Datos de ejemplo en 'usuarios' cargados.<br>";
    }
} else {
    echo "Error al crear tabla usuarios: " . mysqli_error($conexion) . "<br>";
}

mysqli_close($conexion);
?>
</body>
</html>
