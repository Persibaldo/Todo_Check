<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Todo_Check</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .panel { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        h1 { color: #2c3e50; font-size: 1.5rem; margin-bottom: 30px; }
        
        .btn-usuario { display: block; background-color: #28a745; color: white; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-bottom: 25px; }
        .btn-usuario:hover { background-color: #218838; }
        
        .admin-section { border-top: 2px solid #eee; padding-top: 20px; text-align: left; }
        label { display: block; margin-bottom: 10px; font-weight: bold; color: #555; }
        select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        
        .btn-group { display: flex; gap: 10px; }
        button { flex: 1; padding: 10px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; color: white; }
        .btn-insert { background-color: #007bff; }
        .btn-ver { background-color: #6c757d; }
    </style>
</head>
<body>

    <div class="panel">
        <h1>Bienvenido a Todo_Check</h1>

        <a href="bd.php" style="display: block; background-color: #6c757d; color: white; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-bottom: 25px; text-align: center;">
            Inicializar / Restaurar Base de Datos
        </a>

        <a href="catalogo.php" class="btn-usuario">Ver Catálogo Público</a>

        <div class="admin-section">
            <form method="GET">
                <label>Administración de Datos</label>
                
                <select name="tabla">
                    <option value="usuarios">Usuarios</option>
                    <option value="series">Series</option>
                    <option value="juegos">Juegos</option>
                    <option value="anime">Anime</option>
                    <option value="libros">Libros</option>
                    <option value="pelis">Películas</option>
                    <option value="generos">Géneros</option>
                </select>
                
                <div class="btn-group">
                    <button type="submit" formaction="insert.php" class="btn-insert">Insertar</button>
                    <button type="submit" formaction="ver.php" class="btn-ver">Editar/Borrar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
