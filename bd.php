<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Percival">
    <title>Creación de la BD</title>
    <style> 
         /* estilos */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 40px;
    color: #333;
}

.log-container {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: 0 auto;
    border-top: 5px solid #007bff; /* mantiene coherencia de color */
}

/* estilo para cada linea de mensaje de php */
body {
    line-height: 1.8;
    font-size: 0.95rem;
}

.success-msg {
    color: #28a745;
    font-weight: bold;
}

.error-msg {
    color: #dc3545;
    background: #fff5f5;
    padding: 5px;
    border-radius: 4px;
}   
    </style>
</head>
<body>
<?php
// Configuración de conexión
$servidor = 'localhost:3307';
$usuario = 'root';
$password = '';

// 1. Establecer conexión
$conexion = mysqli_connect($servidor, $usuario, $password);

if (!$conexion) {
    die("La Conexión ha fallado: " . mysqli_connect_error());
}

// 2. Crear BD
// --- TABLA USUARIOS ---
$sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    contraseña varchar(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario)
)";
if (mysqli_query($conexion, $sql_usuarios)) {
    echo "Tabla 'usuarios' lista.<br>";
} else {
    echo "Error al crear tabla usuarios: " . mysqli_error($conexion) . "<br>";
}

// --- TABLA GENEROS ---
$sql_generos = "CREATE TABLE IF NOT EXISTS generos (
    id_genero INT NOT NULL AUTO_INCREMENT,
    nombre_genero VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (id_genero)
)";
if (mysqli_query($conexion, $sql_generos)) {
    echo "Tabla 'generos' lista.<br>";
}

// --- TABLA PELIS ---
$sql_pelis = "CREATE TABLE IF NOT EXISTS pelis (
    id_peli INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    director VARCHAR(100),
    duracion_min INT,
    PRIMARY KEY (id_peli)
)";
if (mysqli_query($conexion, $sql_pelis)) {
    echo "Tabla 'pelis' lista.<br>";
}

// --- TABLA SERIES ---
$sql_series = "CREATE TABLE IF NOT EXISTS series (
    id_serie INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    temporadas INT,
    en_emision BOOLEAN,
    PRIMARY KEY (id_serie)
)";
if (mysqli_query($conexion, $sql_series)) {
    echo "Tabla 'series' lista.<br>";
}

// --- TABLA ANIME ---
$sql_anime = "CREATE TABLE IF NOT EXISTS anime (
    id_anime INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    estudio VARCHAR(100),
    episodios INT,
    PRIMARY KEY (id_anime)
)";
if (mysqli_query($conexion, $sql_anime)) {
    echo "Tabla 'anime' lista.<br>";
}

// --- TABLA LIBROS ---
$sql_libros = "CREATE TABLE IF NOT EXISTS libros (
    id_libro INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(100),
    paginas INT,
    PRIMARY KEY (id_libro)
)";
if (mysqli_query($conexion, $sql_libros)) {
    echo "Tabla 'libros' lista.<br>";
}

// --- TABLA JUEGOS ---
$sql_juegos = "CREATE TABLE IF NOT EXISTS juegos (
    id_juego INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    plataforma VARCHAR(100),
    desarrollador VARCHAR(100),
    PRIMARY KEY (id_juego)
)";
if (mysqli_query($conexion, $sql_juegos)) {
    echo "Tabla 'juegos' lista.<br>";
}


// ==========================================
// CREACIÓN DE TABLAS PUENTE (Relaciones N:M)
// ==========================================

$sql_peli_generos = "CREATE TABLE IF NOT EXISTS peli_generos (
    id_peli INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_peli, id_genero),
    FOREIGN KEY (id_peli) REFERENCES pelis(id_peli) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
)";
if (mysqli_query($conexion, $sql_peli_generos)) echo "Tabla puente 'peli_generos' lista.<br>";

$sql_serie_generos = "CREATE TABLE IF NOT EXISTS serie_generos (
    id_serie INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_serie, id_genero),
    FOREIGN KEY (id_serie) REFERENCES series(id_serie) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
)";
if (mysqli_query($conexion, $sql_serie_generos)) echo "Tabla puente 'serie_generos' lista.<br>";

$sql_anime_generos = "CREATE TABLE IF NOT EXISTS anime_generos (
    id_anime INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_anime, id_genero),
    FOREIGN KEY (id_anime) REFERENCES anime(id_anime) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
)";
if (mysqli_query($conexion, $sql_anime_generos)) echo "Tabla puente 'anime_generos' lista.<br>";

$sql_libro_generos = "CREATE TABLE IF NOT EXISTS libro_generos (
    id_libro INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_libro, id_genero),
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
)";
if (mysqli_query($conexion, $sql_libro_generos)) echo "Tabla puente 'libro_generos' lista.<br>";

$sql_juego_generos = "CREATE TABLE IF NOT EXISTS juego_generos (
    id_juego INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_juego, id_genero),
    FOREIGN KEY (id_juego) REFERENCES juegos(id_juego) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
)";
if (mysqli_query($conexion, $sql_juego_generos)) echo "Tabla puente 'juego_generos' lista.<br>";
    
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
