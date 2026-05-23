<?php
// 1. Configuración de conexión (Asegúrate de que el puerto coincida con tu XAMPP, ej: 3306 o 3307)
$servidor = "localhost:3307"; 
$usuario  = "root";
$pass     = "";
$base     = "todo_check";

$conexion = mysqli_connect($servidor, $usuario, $pass, $base) 
    or die("Error de conexión: " . mysqli_connect_error());

// 2. Consulta de datos
$query = "SELECT titulo, tipo, IFNULL(nombre_genero, 'Sin género') AS nombre_genero 
          FROM biblioteca_total 
          ORDER BY tipo ASC, titulo ASC";

$resultado = mysqli_query($conexion, $query);

// 3. Agrupación de datos en el array $catalogo
$catalogo = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $catalogo[$fila['tipo']][] = $fila;
}

// 4. Función de ayuda para iconos y formato
function tipoBonito($tipo){
    switch(strtolower($tipo)){
        case 'peli': case 'pelis': case 'pelicula': case 'peliculas':
            return "🎬 Películas";
        case 'serie': case 'series':
            return "📺 Series";
        case 'anime':
            return "🌸 Anime";
        case 'libro': case 'libros':
            return "📚 Libros";
        case 'juego': case 'juegos':
            return "🎮 Juegos";
        default:
            return "📦 " . ucfirst($tipo);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Todo_Check</title>
    <link rel="stylesheet" href="css/catalogo.css">
</head>

<body>

<nav class="sidebar">
    <h2>📚 Catálogo</h2>
    
    <?php foreach ($catalogo as $tipo => $items): ?>
        <a href="#<?= strtolower(str_replace(' ', '-', $tipo)) ?>">
            <?= tipoBonito($tipo) ?>
        </a>
    <?php endforeach; ?>

    <a class="btn-back" href="index.php">← Volver al Panel</a>
</nav>

<div class="content">
    <h1>📚 Catálogo Todo_Check</h1>

    <?php foreach ($catalogo as $tipo => $items): ?>
        <section class="categoria" id="<?= strtolower(str_replace(' ', '-', $tipo)) ?>">
            
            <h2><?= tipoBonito($tipo) ?></h2>

            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Género</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['titulo']) ?></td>
                            <td><?= htmlspecialchars($item['nombre_genero']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>
    <?php endforeach; ?>
</div>

</body>
</html>
