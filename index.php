<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo_Check - Gestión Multimedia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="container">
        <div class="panel">

            <h1>📋 Todo Check</h1>
            <p class="subtitle">Gestiona y consulta tu catálogo multimedia</p>

            <a href="bd.php" class="btn btn-database">
                🗄️ Inicializar / Restaurar Base de Datos
            </a>

            <a href="catalogo.php" class="btn btn-public">
                📚 Ver Catálogo Público
            </a>

            <div class="admin-section">
                <h2>Administración</h2>

                <form method="GET">
                    <label for="tabla">Selecciona una tabla:</label>

                    <select name="tabla" id="tabla" required>
                        <option value="">-- Elige una opción --</option>
                        <option value="usuarios">Usuarios</option>
                        <option value="series">Series</option>
                        <option value="juegos">Juegos</option>
                        <option value="anime">Anime</option>
                        <option value="libros">Libros</option>
                        <option value="pelis">Películas</option>
                        <option value="generos">Géneros</option>
                    </select>

                    <div class="btn-group">
                        <button type="submit" formaction="insert.php" class="btn btn-insert">
                            ➕ Insertar
                        </button>

                        <button type="submit" formaction="ver.php" class="btn btn-edit">
                            ✏️ Editar / Borrar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
