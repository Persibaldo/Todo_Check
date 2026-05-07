<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Percival">
    <title>Index</title>
    <style>
        /* estilos para la pagina de inicio y seleccion */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
}

form {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    width: 300px;
    text-align: center;
}

label {
    display: block;
    margin-bottom: 15px;
    font-weight: bold;
    color: #2c3e50;
    font-size: 1.1rem;
}

select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background-color: #fff;
    font-family: inherit;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    width: 100%;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <form action="insert.php" method="GET">
        <label>¿Qué desea consultar?</label>
        <select name="tabla">
            <option value="usuarios">Usuarios</option>
            <option value="series">Series</option>
        </select>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
