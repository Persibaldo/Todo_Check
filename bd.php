<!DOCTYPE html >
<html lang=”es” >
<head>
<meta charset = "UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Percival">
<title> Creación de la BD </title>
</head>
<body>
<?php
//MySQL
$servidor = 'localhost:3307';
$usuario = 'root';
$password = '';
$conexion = mysqli_connect($servidor, $usuario, $password);
if(!$conexion){
echo 'La Conexión ha fallado<br>';
}
else{
//crear BD
$sql = "CREATE DATABASE IF NOT EXISTS todo_check";
if (mysqli_query($conexion, $sql)) {
echo "Base de datos creada con éxito";
} else {
echo "Error: " . mysqli_error($conexion);
}
//comprobar creacion
mysqli_select_db($conexion,"todo_check");

//tabla series

$sql2 = "CREATE TABLE todo_check.series(id serial primary key, titulo VARCHAR(20), descripcion varchar (100))";
if(mysqli_query($conexion, $sql2)){
echo "Tabla series creada con éxito";
} else {
echo "La tabla no ha se ha creado ";
}

//tabla usuarios

$sql3 = "CREATE TABLE todo_check.usuarios(id serial primary key, nombre VARCHAR(20), contraseña varchar (20))";
if(mysqli_query($conexion, $sql3)){
echo "Tabla usuarios creada con éxito";
} else {
echo "La tabla no ha se ha creado ";
}
}

?>
</body>
</html>