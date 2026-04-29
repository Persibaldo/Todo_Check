<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ver datos</title>
</head>
<body>

<?php
// BORRAR USUARIO

$conexion = mysqli_connect('localhost:3307', 'root', '');
mysqli_select_db($conexion,"todo_check");

if($accion == "borrar_usuario"){

    $id = $_POST['id'];

    $delusu = mysqli_prepare($conexion,
        "DELETE FROM usuarios WHERE id = ?"
    );

    mysqli_stmt_bind_param($delusu, "i", $id);
    mysqli_stmt_execute($delusu);
    mysqli_stmt_close($delusu);

    header("Location: ver.php?tabla=" . $tabla);
    exit();
}

// BORRAR SERIE

if($accion == "borrar_serie"){

    $id = $_POST['id'];

    $delserie = mysqli_prepare($conexion,
        "DELETE FROM series WHERE id = ?"
    );

    mysqli_stmt_bind_param($delserie, "i", $id);
    mysqli_stmt_execute($delserie);
    mysqli_stmt_close($delserie);

    header("Location: ver.php?tabla=" . $tabla);
    exit();
}

if($tabla == "usuarios"){
?>

<h2>Usuarios</h2>

<table>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>

<?php
$result = mysqli_query($conexion, "SELECT id, nombre FROM usuarios");

while($fila = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $fila['id']; ?></td>
    <td><?php echo $fila['nombre']; ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="tabla" value="usuarios">
            <input type="hidden" name="accion" value="borrar_usuario">
            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
            <button type="submit">Borrar</button>
        </form>
    </td>
</tr>
<?php
}
?>

</table>

<?php
}

// INTERFAZ SERIES

if($tabla == "series"){
?>

<h2>Insertar Serie</h2>

<form method="POST">
    <input type="hidden" name="tabla" value="series">
    <input type="hidden" name="accion" value="guardar_serie">
    Título: <input type="text" name="titulo" required><br><br>
    Descripción: <input type="text" name="descripcion" required><br><br>
    <button type="submit">Guardar</button>
</form>

<h2>Series existentes</h2>

<table>
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Descripción</th>
    <th>Acciones</th>
</tr>

<?php
$result = mysqli_query($conexion, "SELECT * FROM series");

while($fila = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $fila['id']; ?></td>
    <td><?php echo $fila['titulo']; ?></td>
    <td><?php echo $fila['descripcion']; ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="tabla" value="series">
            <input type="hidden" name="accion" value="borrar_serie">
            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
            <button type="submit">Borrar</button>
        </form>
    </td>
</tr>
<?php
}
?>

</table>

<?php
}
?>

</body>
</html>