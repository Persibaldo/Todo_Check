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
//MySQL
$servidor = 'localhost:3307';
$usuario = 'root';
$password = '';
$conexion = mysqli_connect($servidor, $usuario, $password);

if (!$conexion) {
    echo 'La Conexión ha fallado<br>';
} else {
    //crear BD
    $sql = "CREATE DATABASE IF NOT EXISTS todo_check";
    if (mysqli_query($conexion, $sql)) {
        echo "Base de datos creada con éxito<br>";
    } else {
        echo "Error: " . mysqli_error($conexion) . "<br>";
    }
    
    //comprobar creacion
    mysqli_select_db($conexion, "todo_check");

    //tabla series
    $sql2 = "CREATE TABLE IF NOT EXISTS todo_check.series(id serial primary key, titulo VARCHAR(20), descripcion VARCHAR(100))";
    if (mysqli_query($conexion, $sql2)) {
        echo "Tabla series creada con éxito<br>";
    } else {
        echo "La tabla no se ha creado<br>";
    }

    //tabla usuarios
    $sql3 = "CREATE TABLE IF NOT EXISTS todo_check.usuarios(id serial primary key, nombre VARCHAR(20), contraseña VARCHAR(255))";
    if (mysqli_query($conexion, $sql3)) {
        echo "Tabla usuarios creada con éxito<br>";
    } else {
        echo "La tabla no se ha creado<br>";
    }
}
?>
</body>
</html>
